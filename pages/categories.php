<?php

$content = "";

$category_id = rex_request('category_id', 'int');
$func = rex_request('func', 'string');
$clang_id = rex_request('clang_id', 'int', rex_clang::getStartId());

$fragment = new rex_fragment();

$success = "";
$error = "";

if ($func == 'delete' && $category_id > 0) {
    $sql = rex_sql::factory();
    //$sql->setDebug();
    $sql->setTable(rex::getTablePrefix() . 'newsmanager_categories');
    $sql->setWhere(['id' => $category_id]);

    try {
        $sql->delete();
        $success = rex_i18n::msg('category_deleted');
    } catch (rex_sql_exception $e) {
        $error = $sql->getError();
    }
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
    if (count(rex_clang::getAll(1))>1) {
        echo '<div class="rex-nav-btn news-lang-switch"><div class="btn-toolbar"><div class="btn-group pull-right">'.PHP_EOL;
        foreach(rex_clang::getAll(1) as $key => $lang) {

            if ($clang_id == $lang->getId()) {
                $active = 'class="btn btn-clang active"';
            } else {
                $active = 'class="btn btn-clang"';
            }
            echo '<a '.$active.' href="index.php?page=newsmanager/categories&clang_id='.$lang->getId().'"><i class="rex-icon rex-icon-online"></i> '. $lang->getName() .'</a>';
        }
        echo '</div></div></div>'.PHP_EOL;
    }


    $fragment->setVar('title', $this->i18n('categories'), false);

    //$clang_id = 1;

    $list = rex_list::factory('SELECT pid,id,name,clang_id FROM ' . rex::getTablePrefix() . 'newsmanager_categories WHERE clang_id = '.$clang_id.' ORDER BY name ASC', 25);
    $list->addTableAttribute('class', 'table-striped');
    $tdIcon = '<i class="rex-icon fa-tag"></i>';
    $thIcon = '<a href="' . $list->getUrl(['clang_id' => $clang_id, 'func' => 'add']) . '"><i class="rex-icon rex-icon-add"></i></a>';

    $list->addColumn($thIcon, $tdIcon, 0, ['<th class="rex-table-icon">###VALUE###</th>', '<td class="rex-table-icon">###VALUE###</td>']);
    $list->setColumnParams($thIcon, ['clang_id' => $clang_id, 'func' => 'edit', 'category_id' => '###pid###']);

    $list->removeColumn('pid');
    $list->removeColumn('id');
    $list->removeColumn('clang_id');

    $list->setColumnLabel('name', 'Name');
    $list->setColumnSortable('name');
    $list->setColumnParams('name', ['clang_id' => $clang_id, 'func' => 'edit', 'category_id' => '###pid###']);


    $list->addColumn('deleteCategory', '', -1, ['<th></th>', '<td class="rex-table-action">###VALUE###</td>']);
    $list->setColumnParams('deleteCategory', ['clang_id' => $clang_id, 'category_id' => '###id###', 'func' => 'delete']);
    $list->addLinkAttribute('deleteCategory', 'data-confirm', rex_i18n::msg('category_delete_question') . ' ?');
    $list->setColumnFormat('deleteCategory', 'custom', function ($params) {
        $list = $params['list'];
        return $list->getColumnLink('deleteCategory', '<i class="rex-icon rex-icon-delete"></i> ' . rex_i18n::msg('newsmanager_delete'));
    });

    $content .= $list->get();
} elseif ($func == 'add' || $func == 'edit') {

    $fragment->setVar('title', $this->i18n('category'), false);

    $form = rex_form::factory(rex::getTablePrefix() . 'newsmanager_categories', '', 'pid = ' . $category_id);

    $form->setLanguageSupport('id', 'clang_id');

    $form->addParam('category_id', $category_id);
    $form->addParam('clang_id', $clang_id);

    if ($func == 'edit') {
        $form->setEditMode($func == 'edit');
    }

    $field = $form->addTextField('name');
    $field->setLabel(rex_i18n::msg('category_form_name'));

    $content .= $form->get();

    $fragment->setVar('class', 'edit');
}

$content .= <<<END

        <style>
            .news-lang-switch {
                position: absolute;
                right: 15px;
                margin: 4px;
            }
        </style>
END;



$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
