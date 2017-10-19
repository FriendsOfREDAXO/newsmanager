<?php

$id = rex_request('id', 'int');
$func = rex_request('func', 'string');

$content = '';

$fragment = new rex_fragment();

if ($func == 'delete' && $id > 0) {
    
    $sql = rex_sql::factory();
    //$sql->setDebug();
    $sql->setTable(rex::getTablePrefix() . 'newsmanager_comments');
    $sql->setWhere(['id' => $id]);

    try {
        $sql->delete();
        $success = rex_i18n::msg('newsmanager_deleted');
    } catch (rex_sql_exception $e) {
        $error = $sql->getError();
    }
    $func = '';
}

if ($func == 'status' && $id > 0) {
    
    $sql = rex_sql::factory();
    
    try {
        $sql->setQuery('UPDATE '. rex::getTablePrefix() . 'newsmanager_comments SET status = IF(status=1, 0, 1) WHERE id = '.$id.'');
        
    } catch (rex_sql_exception $e) {
        $error = $sql->getError();
    }

    $func = '';
}

if ($func == "") {
    $fragment->setVar('title', $this->i18n('comments_title'), false);
    
    $list = rex_list::factory(''
            . 'SELECT * '
            . 'FROM ' . rex::getTablePrefix() . 'newsmanager_comments '
            . 'ORDER BY createdate DESC', 25);
    
    $list->addTableAttribute('class', 'table-striped');
    
    $tdIcon = '<i class="rex-icon fa-comment"></i>';
    $thIcon = '';
    $list->addColumn($thIcon, $tdIcon, 0, ['<th class="rex-table-icon">###VALUE###</th>', '<td class="rex-table-icon">###VALUE###</td>']);
    $list->setColumnParams($thIcon, ['func' => 'edit', 'id' => '###id###']);
    
    $list->removeColumn('id');
    $list->removeColumn('re_article_pid');
    $list->removeColumn('email');
    
    $list->setColumnLabel('comment', rex_i18n::msg("comment_tableheader_comment"));
    $list->setColumnSortable('comment');
    $list->setColumnFormat('comment', 'custom', function($params) {
        $list = $params['list'];
        // Kommentar kürzen und Punkte dranhängen 
        if (strlen($params['value']) > 70) {
            $comment = substr(preg_replace("/[^ ]*$/", '', substr($params['value'], 0, 70)), 0, -1) . '...';
        } else {
            $comment = $params['value'];
        }
        return $list->getColumnLink('comment', $comment , ['func' => 'edit', 'id' => '###id###']);
    });
   
    $list->setColumnLabel('name', rex_i18n::msg("comment_tableheader_name"));
    $list->setColumnSortable('name');
    
    $list->setColumnLabel('createdate', rex_i18n::msg('comment_tableheader_createdate'));
    $list->setColumnSortable('createdate');
    $list->setColumnFormat('createdate', 'date', 'd.m.Y, G:i');
    
    $list->setColumnFormat('status', 'custom',
        create_function(
            '$params',
            'global $I18N;
$list = $params["list"];
if ($list->getValue("status") == 1)
$str = "<a class=\"no-wrap\" href=\"index.php?page=newsmanager/comments&func=status&id=###id###\"><span class=\"rex-online\"><i class=\"rex-icon rex-icon-online\"></i> ".rex_i18n::msg("comment_online")."</span></a>";
else
$str = "<a class=\"no-wrap\" href=\"index.php?page=newsmanager/comments&func=status&id=###id###\"><span class=\"rex-offline\"><i class=\"rex-icon rex-icon-offline\"></i> ".rex_i18n::msg("comment_offline")."</span></a>";
return $str;'
        )
    );
    
    $list->setColumnLabel('status', rex_i18n::msg('comment_tableheader_status'));
    $list->setColumnSortable('status');
    
    $list->addColumn('deleteComment', '', -1, ['<th></th>', '<td class="rex-table-action">###VALUE###</td>']);
    $list->setColumnParams('deleteComment', ['id' => '###id###', 'func' => 'delete']);
    $list->addLinkAttribute('deleteComment', 'data-confirm', rex_i18n::msg('newsmanager_delete_question') . ' ?');
    $list->setColumnFormat('deleteComment', 'custom', function ($params) {
        $list = $params['list'];
        return $list->getColumnLink('deleteComment', '<i class="rex-icon rex-icon-delete"></i> ' . rex_i18n::msg('newsmanager_delete'));
    });
    
    $content .= $list->get();
} elseif ($func == 'edit') {
    
    $user = '';
    $headline = $this->i18n('comment_title_fragment');

    $form = rex_form::factory(rex::getTablePrefix() . 'newsmanager_comments', '', 'id = ' . $id);
    
    $result = $form->getSql();
 
    $article_id = $result->getArrayValue('re_article_pid');

    $article_result = rex_sql::factory();
    //$article_result->setDebug();
    $article_result->getArray('SELECT `title` FROM ' . rex::getTablePrefix() . 'newsmanager WHERE `pid` = '. $article_id );
    
    $headline .= ': "' . $article_result->getArray()[0]['title'] . '"';
    
    $fragment->setVar('title', $headline, false);
    
    $form->addParam('id', $id);
    
    $field = $form->addReadOnlyTextField('createdate');
    $field->setLabel(rex_i18n::msg('comment_label_createdate'));
    
    $field = $form->addTextField('name');
    $field->setLabel(rex_i18n::msg('comment_label_name'));
    
    $field = $form->addTextField('email');
    $field->setLabel(rex_i18n::msg('comment_label_email'));
    
    $field = $form->addTextAreaField('comment');
    $field->setLabel(rex_i18n::msg('comment_label_comment'));
    
    $form->getMessage();
    $content .= $form->get();
    
    $fragment->setVar('class', 'edit');
}

$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');