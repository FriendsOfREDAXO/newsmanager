<?php

function generateHelpTextMarkup ($form, $fieldName, $i18n_key_helptext) {
    $field = $form->addRawField(
        '<dl class="rex-form-group form-group">
            <dt>
            </dt>
            <dd>
                <i class="fa fa-question-circle" aria-hidden="true"></i> 
                <a class="help" role="button" data-toggle="collapse" href="#help-'. $fieldName. '" aria-expanded="false" aria-controls="help-'. $fieldName. '">
                    Hilfe
                </a>
                <div class="collapse" id="help-'. $fieldName. '">
                    <div class="well">
                      <p class="help-block">
                          <small>
                              '. rex_i18n::rawMsg($i18n_key_helptext) . '
                          </small>
                      </p>
                    </div>
                </div>
            </dd>
        </dl>'
    );
    $field->setLabel(rex_i18n::msg('newsmanager_form_help_label'));
}

$content = "";

$pid = rex_request('pid', 'int');
$id = rex_request('id', 'int');
$func = rex_request('func', 'string');
$clang_id = rex_request('clang_id', 'int');

$fragment = new rex_fragment();

if ($clang_id == "") {
    $clang_id = 1;
}
$success = "";
$error = "";

if ($func == 'delete' && $id > 0) {
    $sql = rex_sql::factory();
    //$sql->setDebug();
    $sql->setTable(rex::getTablePrefix() . 'newsmanager');
    $sql->setWhere(['id' => $id]);

    try {
        $sql->delete();
        $success = rex_i18n::msg('newsmanager_deleted');
    } catch (rex_sql_exception $e) {
        $error = $sql->getError();
    }
    $func = '';
}

//-------------- copy news
if ($func == 'copy' && $pid > 0) {
    $sql = rex_sql::factory();
    
    $lastId = $sql->getArray('SELECT MAX(id) as lastId FROM '. rex::getTablePrefix() . 'newsmanager');   
    $lastId = $lastId[0]['lastId'] + 1;
    
    if (count(rex_clang::getAll(1))>=1) {
        foreach(rex_clang::getAll(1) as $key => $lang) {
            try {
                $query = 'INSERT INTO '. rex::getTablePrefix() . 'newsmanager '
                        . '(`status`, '
                        . '`id`, '
                        . '`newsmanager_category_id`, '
                        . '`title`, '
                        . '`subtitle`, '
                        . '`richtext`, '
                        . '`images`, '
						. '`seo_title`, '
                        . '`seo_description`, '
                        . '`seo_canonical`, '
                        . '`author`, '
                        . 'createuser, '
                        . 'createdate, '
                        . 'updateuser, '
                        . 'updatedate, '
                        . 'clang_id) '
                        . 'SELECT 0, '
                        . $lastId .', '
                        . '`newsmanager_category_id`, '
                        . 'CONCAT("Kopie_", title) , '
                        . '`subtitle`, '
                        . '`richtext`, '
                        . '`images`, '
						. '`seo_title`, '
                        . '`seo_description`, '
                        . '`seo_canonical`, '
                        . '`author`, '
                        . '"'.rex::getUser()->getlogin().'", '
                        . 'createdate, '
                        . '"'.rex::getUser()->getlogin().'", '
                        . 'updatedate, '
                        . $lang->getId().' '
                        . 'FROM '. rex::getTablePrefix() . 'newsmanager '
                        . 'WHERE pid = '.$pid.'';

                $sql->setQuery($query);
                // $sql->setDebug();
                $success = rex_i18n::msg('newsmanager_copied');
            } catch (rex_sql_exception $e) {
                $error = $sql->getError();
            }
        }
    }

    UrlGenerator::generatePathFile([]);
    
    $func = '';
}

if ($func == 'status' && $pid > 0) {
    $sql = rex_sql::factory();

    try {
        $sql->setQuery('UPDATE '. rex::getTablePrefix() . 'newsmanager SET status = IF(status=1, 0, 1) WHERE pid = '.$pid.'');
        //$success = rex_i18n::msg('newsmanager_copied');
    } catch (rex_sql_exception $e) {
        $error = $sql->getError();
    }

    UrlGenerator::generatePathFile([]);
    
    $func = '';
}

//-------------- output messages
if ($success != '') {
    echo rex_view::success($success);
}

if ($error != '') {
    echo rex_view::error($error);
}
if ($func == "") {
    
    $fragment->setVar('title', $this->i18n('main_title'), false);

    if (count(rex_clang::getAll(1))>1) {
        echo '<div class="rex-nav-btn news-lang-switch"><div class="btn-toolbar"><div class="btn-group pull-right">'.PHP_EOL;
        foreach(rex_clang::getAll(1) as $key => $lang) {
            
            if ($clang_id == $lang->getId()) {
                $active = 'class="btn btn-clang active"';
            } else {
                $active = 'class="btn btn-clang"';
            }
            echo '<a '.$active.' href="index.php?page=newsmanager/main&clang_id='.$lang->getId().'"><i class="rex-icon rex-icon-online"></i> '. $lang->getName() .'</a>';
        }
        echo '</div></div></div>'.PHP_EOL;
    }

    $list = rex_list::factory('SELECT pid, id, title,createdate,status,clang_id FROM ' . rex::getTablePrefix() . 'newsmanager WHERE clang_id = '.$clang_id.' ORDER BY createdate DESC', 25);
    $list->addTableAttribute('class', 'table-striped');
    $tdIcon = '<i class="rex-icon rex-icon-article"></i>';
    $thIcon = '<a href="' . $list->getUrl(['clang_id' => $clang_id, 'func' => 'add']) . '"><i class="rex-icon rex-icon-add"></i></a>';

    $list->addColumn($thIcon, $tdIcon, 0, ['<th class="rex-table-icon">###VALUE###</th>', '<td class="rex-table-icon">###VALUE###</td>']);
    $list->setColumnParams($thIcon, ['clang_id' => $clang_id, 'func' => 'edit', 'pid' => '###pid###']);

    $list->removeColumn('id');
    $list->removeColumn('pid');
    $list->removeColumn('clang_id');
    
    $list->setColumnLabel('title', 'Titel');
    $list->setColumnSortable('title');
    $list->setColumnParams('title', ['clang_id' => $clang_id, 'func' => 'edit', 'pid' => '###pid###']);
    
    $list->setColumnLabel('createdate', rex_i18n::msg("newsmanager_list_createdate"));
    
    $list->setColumnFormat('createdate', 'date', 'd.m.Y, G:i');
    $list->setColumnSortable('createdate');
    
    $list->setColumnFormat('status', 'custom', function ($params) {
            global $I18N;
			$list = $params['list'];
			if ($list->getValue("status") == 1)
			$str = "<a class=\"no-wrap\" href=\"index.php?page=newsmanager/main&clang_id='.$clang_id.'&func=status&pid=###pid###\"><span class=\"rex-online\"><i class=\"rex-icon rex-icon-online\"></i> ".rex_i18n::msg("newsmanager_online")."</span></a>";
			else
			$str = "<a class=\"no-wrap\" href=\"index.php?page=newsmanager/main&clang_id='.$clang_id.'&func=status&pid=###pid###\"><span class=\"rex-offline\"><i class=\"rex-icon rex-icon-offline\"></i> ".rex_i18n::msg("newsmanager_offline")."</span></a>";
			return $str;
        }
    );
	
   
    
    $list->setColumnLabel('status', 'Status');
    $list->setColumnSortable('status');
    
    $list->addColumn('copyType', '<i class="rex-icon rex-icon-duplicate"></i> ' . rex_i18n::msg('newsmanager_copy'), -1, ['<th></th>', '<td class="rex-table-action">###VALUE###</td>']);
    $list->setColumnParams('copyType', ['func' => 'copy', 'pid' => '###pid###']);
    
    
    $list->addColumn('deleteNews', '', -1, ['<th></th>', '<td class="rex-table-action">###VALUE###</td>']);
    $list->setColumnParams('deleteNews', ['clang_id' => $clang_id, 'id' => '###id###', 'func' => 'delete']);
    $list->addLinkAttribute('deleteNews', 'data-confirm', rex_i18n::msg('newsmanager_delete_question') . ' ?');
    $list->setColumnFormat('deleteNews', 'custom', function ($params) {
        $list = $params['list'];
        return $list->getColumnLink('deleteNews', '<i class="rex-icon rex-icon-delete"></i> ' . rex_i18n::msg('newsmanager_delete'));
    });
    
    $content .= $list->get();
} elseif ($func == 'add' || $func == 'edit') {
    
    $categories = rex_sql::factory();
    
    $categories->setQuery('SELECT * FROM '.rex::getTablePrefix() . 'newsmanager_categories WHERE clang_id = '.$clang_id);
    
    $fragment->setVar('title', $this->i18n('newsmanager_form_article_title') .' ('. rex_clang::get($clang_id)->getName() .')' , false);

    //$form = rex_form::factory(rex::getTablePrefix() . 'newsmanager', '', 'pid = ' . $pid, 'post', true); //DEBUG
    $form = rex_form::factory(rex::getTablePrefix() . 'newsmanager', '', 'pid = ' . $pid);
    
    $form->setLanguageSupport('id', 'clang_id');
        
    $form->addParam('pid', $pid);
    $form->addParam('clang_id', $clang_id);

   
    if ($func == 'edit') {
        $form->setEditMode($func == 'edit');
    }
    
    $field = $form->addFieldset('Artikel');
    $field = $form->addTextField('title');
    $field->setLabel(rex_i18n::msg('newsmanager_form_title'));

    $field = $form->addTextField('subtitle');    /* 2018-01-18-TB */
    $field->setLabel(rex_i18n::msg('newsmanager_form_subtitle'));
    
    
    $field = $form->addTextField('createdate', null, array('class'=>'form-control datetimepicker'));
    $field->setLabel(rex_i18n::msg('newsmanager_form_createdate'));
    
    $field = $form->addTextAreaField('richtext', null, array('class'=>'redactorEditor2-newsmanager') );
    $field->setLabel(rex_i18n::msg('newsmanager_form_richtext'));
    
    generateHelpTextMarkup($form, 'richtext', 'newsmanager_form_help_richtext');
    
    $field = $form->addTextField('author');
    if ($field->getValue() == "") {
        $field->setValue(rex::getUser()->getName());    
    } 
    $field->setLabel(rex_i18n::msg('newsmanager_form_author'));
    
    generateHelpTextMarkup($form, 'author', 'newsmanager_form_help_author');
    
    $field = $form->addFieldset('Kategorien');
    
    $field = $form->addSelectField('newsmanager_category_id'); 
    $field->setLabel(rex_i18n::msg('newsmanager_form_category_select'));
    $field->setAttribute('class', 'selectpicker');
    $field->setAttribute('multiple', 'multiple');
    $select = $field->getSelect();
    foreach ($categories as $category) {
        $select->addOption($category->getValue('name'), $category->getValue('id'));
    }
    
    generateHelpTextMarkup($form, 'newsmanager_category', 'newsmanager_form_help_category');
    
    $field = $form->addFieldset('Bilder');
    $field = $form->addMedialistField('images');
    $field->setLabel(rex_i18n::msg('newsmanager_form_images'));
    
    generateHelpTextMarkup($form, 'images', 'newsmanager_form_help_images');

    $field = $form->addFieldset('SEO Einstellungen');
    
	$field = $form->addTextField('seo_title');
    $field->setLabel(rex_i18n::msg('newsmanager_form_seo_title'));
    
	
    $field = $form->addTextAreaField('seo_description');
    $field->setLabel(rex_i18n::msg('newsmanager_form_seo_description'));
    
    generateHelpTextMarkup($form, 'seo_description', 'newsmanager_form_help_meta_description');
    
    $field = $form->addTextField('seo_canonical');
    $field->setLabel(rex_i18n::msg('newsmanager_form_seo_canonical'));
    
    generateHelpTextMarkup($form, 'seo_canonical', 'newsmanager_form_help_seo_canonical');
    
    $fragment->setVar('class', 'edit');
    
    

$jScript = <<<END
<script type="text/javascript">
    $(function () {  
        $('.datetimepicker').datetimepicker({
            defaultDate: new Date(),
            sideBySide: true,
            locale: 'de',
            format: 'YYYY-MM-DD HH:mm'   
        });
    });
</script>
END;
    $form->getMessage();
    $content .= $form->get();
    
    $content .= $jScript;
    
    UrlGenerator::generatePathFile([]);
    
}

$content .= <<<END

        <style>
            .news-lang-switch {
                position: absolute;
                right: 15px;
                margin: 4px;
            }
            .help-block {
                padding: 5px 0px 0px 0px;
            }
            .no-wrap {
                white-space: nowrap;
            }
        </style>
END;

$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
