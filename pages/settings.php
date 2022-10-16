<?php

$content = '';
$buttons = '';
$profileTable = rex::getTable('url_generator_profile');

if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
        ['newsmanager-page-id', 'array[int]'],
    ]));

    if (rex_addon::getConfig('newsmanager-page-id')) {
        $id = rex_addon::getConfig('newsmanager-page-id')[0];

        if ($id > 0) {
            $article_id = $id;
            $user = rex::getUser()->getLogin();

            if (count(rex_clang::getAll()) == 1) {
                $query = "DELETE FROM $profileTable WHERE `table_name` = '1_xxx_rex_newsmanager'";
                $result = rex_sql::factory()->setQuery($query);
                $query = "DELETE FROM $profileTable WHERE `table_name` LIKE '1_xxx_rex_newsmanager_categories'";
                $result = rex_sql::factory()->setQuery($query);

                $newsManagerSql = rex_sql::factory();
                $newsManagerSql->setTable($profileTable);
                $newsManagerSql->setValue('namespace', 'newsmanager');
                $newsManagerSql->setValue('article_id', $article_id);
                $newsManagerSql->setValue('clang_id', rex_clang::getStartId());
                $newsManagerSql->setValue('ep_pre_save_called', 0);
                $newsManagerSql->setValue('table_name', '1_xxx_rex_newsmanager');
                $newsManagerSql->setValue('table_parameters', '{"column_id":"id","column_clang_id":"clang_id","restriction_1_column":"status","restriction_1_comparison_operator":"=","restriction_1_value":"1","restriction_2_logical_operator":"","restriction_2_column":"","restriction_2_comparison_operator":"=","restriction_2_value":"","restriction_3_logical_operator":"","restriction_3_column":"","restriction_3_comparison_operator":"=","restriction_3_value":"","column_segment_part_1":"title","column_segment_part_2_separator":"\/","column_segment_part_2":"","column_segment_part_3_separator":"\/","column_segment_part_3":"","relation_1_column":"","relation_1_position":"BEFORE","relation_2_column":"","relation_2_position":"BEFORE","relation_3_column":"","relation_3_position":"BEFORE","append_user_paths":"","append_structure_categories":"0","column_seo_title":"title","column_seo_description":"seo_description","column_seo_image":"","sitemap_add":"1","sitemap_frequency":"daily","sitemap_priority":"1.0","column_sitemap_lastmod":"updatedate"}');
                $newsManagerSql->setValue('relation_1_table_name', '');
                $newsManagerSql->setValue('relation_1_table_parameters', '[]');
                $newsManagerSql->setValue('relation_2_table_name', '');
                $newsManagerSql->setValue('relation_2_table_parameters', '[]');
                $newsManagerSql->setValue('relation_3_table_name', '');
                $newsManagerSql->setValue('relation_3_table_parameters', '[]');
                $newsManagerSql->setValue('createdate', rex_sql::datetime());
                $newsManagerSql->setValue('updatedate', rex_sql::datetime());
                $newsManagerSql->setValue('createuser', $user);
                $newsManagerSql->setValue('updateuser', $user);
                $newsManagerSql->insert();

                $newsManagerSqlCategories = rex_sql::factory();
                $newsManagerSqlCategories->setTable($profileTable);
                $newsManagerSqlCategories->setValue('namespace', 'newsmanager_category');
                $newsManagerSqlCategories->setValue('article_id', $article_id);
                $newsManagerSqlCategories->setValue('clang_id', rex_clang::getStartId());
                $newsManagerSqlCategories->setValue('ep_pre_save_called', 0);
                $newsManagerSqlCategories->setValue('table_name', '1_xxx_rex_newsmanager_categories');
                $newsManagerSqlCategories->setValue('table_parameters', '{"column_id":"id","column_clang_id":"clang_id","restriction_1_column":"","restriction_1_comparison_operator":"=","restriction_1_value":"","restriction_2_logical_operator":"","restriction_2_column":"","restriction_2_comparison_operator":"=","restriction_2_value":"","restriction_3_logical_operator":"","restriction_3_column":"","restriction_3_comparison_operator":"=","restriction_3_value":"","column_segment_part_1":"name","column_segment_part_2_separator":"\/","column_segment_part_2":"","column_segment_part_3_separator":"\/","column_segment_part_3":"","relation_1_column":"","relation_1_position":"BEFORE","relation_2_column":"","relation_2_position":"BEFORE","relation_3_column":"","relation_3_position":"BEFORE","append_user_paths":"","append_structure_categories":"0","column_seo_title":"name","column_seo_description":"","column_seo_image":"","sitemap_add":"1","sitemap_frequency":"always","sitemap_priority":"1.0","column_sitemap_lastmod":"updatedate"}');
                $newsManagerSqlCategories->setValue('relation_1_table_name', '');
                $newsManagerSqlCategories->setValue('relation_1_table_parameters', '[]');
                $newsManagerSqlCategories->setValue('relation_2_table_name', '');
                $newsManagerSqlCategories->setValue('relation_2_table_parameters', '[]');
                $newsManagerSqlCategories->setValue('relation_3_table_name', '');
                $newsManagerSqlCategories->setValue('relation_3_table_parameters', '[]');
                $newsManagerSqlCategories->setValue('createdate', rex_sql::datetime());
                $newsManagerSqlCategories->setValue('updatedate', rex_sql::datetime());
                $newsManagerSqlCategories->setValue('createuser', $user);
                $newsManagerSqlCategories->setValue('updateuser', $user);
                $newsManagerSqlCategories->insert();
            }
            else {
                $query = "DELETE FROM $profileTable WHERE `table_name` = '1_xxx_rex_newsmanager'";
                $result = rex_sql::factory()->setQuery($query);
                $query = "DELETE FROM $profileTable WHERE `table_name` LIKE '1_xxx_rex_newsmanager_categories'";
                $result = rex_sql::factory()->setQuery($query);

                $newsManagerSql = rex_sql::factory();
                $newsManagerSql->setTable($profileTable);
                $newsManagerSql->setValue('namespace', 'newsmanager');
                $newsManagerSql->setValue('article_id', $article_id);
                $newsManagerSql->setValue('clang_id', 0);
                $newsManagerSql->setValue('ep_pre_save_called', 0);
                $newsManagerSql->setValue('table_name', '1_xxx_rex_newsmanager');
                $newsManagerSql->setValue('table_parameters', '{"column_id":"id","column_clang_id":"clang_id","restriction_1_column":"status","restriction_1_comparison_operator":"=","restriction_1_value":"1","restriction_2_logical_operator":"","restriction_2_column":"","restriction_2_comparison_operator":"=","restriction_2_value":"","restriction_3_logical_operator":"","restriction_3_column":"","restriction_3_comparison_operator":"=","restriction_3_value":"","column_segment_part_1":"title","column_segment_part_2_separator":"\/","column_segment_part_2":"","column_segment_part_3_separator":"\/","column_segment_part_3":"","relation_1_column":"","relation_1_position":"BEFORE","relation_2_column":"","relation_2_position":"BEFORE","relation_3_column":"","relation_3_position":"BEFORE","append_user_paths":"","append_structure_categories":"0","column_seo_title":"title","column_seo_description":"seo_description","column_seo_image":"","sitemap_add":"1","sitemap_frequency":"daily","sitemap_priority":"1.0","column_sitemap_lastmod":"updatedate"}');
                $newsManagerSql->setValue('relation_1_table_name', '');
                $newsManagerSql->setValue('relation_1_table_parameters', '[]');
                $newsManagerSql->setValue('relation_2_table_name', '');
                $newsManagerSql->setValue('relation_2_table_parameters', '[]');
                $newsManagerSql->setValue('relation_3_table_name', '');
                $newsManagerSql->setValue('relation_3_table_parameters', '[]');
                $newsManagerSql->setValue('createdate', rex_sql::datetime());
                $newsManagerSql->setValue('updatedate', rex_sql::datetime());
                $newsManagerSql->setValue('createuser', $user);
                $newsManagerSql->setValue('updateuser', $user);
                $newsManagerSql->insert();

                $newsManagerSqlCategories = rex_sql::factory();
                $newsManagerSqlCategories->setTable($profileTable);
                $newsManagerSqlCategories->setValue('namespace', 'newsmanager_category');
                $newsManagerSqlCategories->setValue('article_id', $article_id);
                $newsManagerSqlCategories->setValue('clang_id', 0);
                $newsManagerSqlCategories->setValue('ep_pre_save_called', 0);
                $newsManagerSqlCategories->setValue('table_name', '1_xxx_rex_newsmanager_categories');
                $newsManagerSqlCategories->setValue('table_parameters', '{"column_id":"id","column_clang_id":"clang_id","restriction_1_column":"","restriction_1_comparison_operator":"=","restriction_1_value":"","restriction_2_logical_operator":"","restriction_2_column":"","restriction_2_comparison_operator":"=","restriction_2_value":"","restriction_3_logical_operator":"","restriction_3_column":"","restriction_3_comparison_operator":"=","restriction_3_value":"","column_segment_part_1":"name","column_segment_part_2_separator":"\/","column_segment_part_2":"","column_segment_part_3_separator":"\/","column_segment_part_3":"","relation_1_column":"","relation_1_position":"BEFORE","relation_2_column":"","relation_2_position":"BEFORE","relation_3_column":"","relation_3_position":"BEFORE","append_user_paths":"","append_structure_categories":"0","column_seo_title":"name","column_seo_description":"","column_seo_image":"","sitemap_add":"1","sitemap_frequency":"always","sitemap_priority":"1.0","column_sitemap_lastmod":"updatedate"}');
                $newsManagerSqlCategories->setValue('relation_1_table_name', '');
                $newsManagerSqlCategories->setValue('relation_1_table_parameters', '[]');
                $newsManagerSqlCategories->setValue('relation_2_table_name', '');
                $newsManagerSqlCategories->setValue('relation_2_table_parameters', '[]');
                $newsManagerSqlCategories->setValue('relation_3_table_name', '');
                $newsManagerSqlCategories->setValue('relation_3_table_parameters', '[]');
                $newsManagerSqlCategories->setValue('createdate', rex_sql::datetime());
                $newsManagerSqlCategories->setValue('updatedate', rex_sql::datetime());
                $newsManagerSqlCategories->setValue('createuser', $user);
                $newsManagerSqlCategories->setValue('updateuser', $user);
                $newsManagerSqlCategories->insert();
            }

            Url\Url::resolveCurrent();
        }
    }
    if (rex_addon::get('redactor2')->isAvailable()) {
        if (!redactor2::profileExists('newsmanager')) {
            redactor2::insertProfile('newsmanager', 'Angelegt durch das News-Manager Addon', '300', '800', 'relative', '0', '0', '0', '1', 'groupheading[2|3|4|5|6],paragraph,bold, italic, underline,deleted, sub, sup,  unorderedlist, orderedlist,video,media,grouplink[email|external|internal|media|telephone], cleaner,horizontalrule,source,fullscreen');
            echo rex_view::success('Das nötige Redactor2-Profil wurde angelegt');
        }
    }
    else {
        echo rex_view::info($this->i18n('settings_error_redactor2'));
    }

    echo rex_view::success($this->i18n('settings_saved'));
}

$content .= '<fieldset><legend>' . $this->i18n('settings_category') . '</legend>';

$content .= '<p>' . $this->i18n('settings_description') . '</p>';

// Kategorienauswahl

$n = [];
$n['label'] = '<label for="demo_addon-config-categories">' . $this->i18n('settings_category_label') . '</label>';

$category_select = new rex_category_select(false, false, false, false);
$category_select->setName('config[newsmanager-page-id][]');
$category_select->setAttribute('class', 'selectpicker');
$category_select->setId('newsmanager-page-id');
$category_select->setSize('1');
$category_select->setMultiple(false);
$category_select->setAttribute('style', 'width:100%');
$category_select->setSelected($this->getConfig('newsmanager-page-id'));

$n['field'] = $category_select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$content .= '</fieldset>';

// Save-Button
$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-save rex-form-aligned" type="submit" name="save" value="' . $this->i18n('newsmanager_settings_save') . '">' . $this->i18n('newsmanager_settings_save') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');
$buttons = '
<fieldset class="rex-form-action">
    ' . $buttons . '
</fieldset>
';

// Ausgabe Formular
$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('config'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$output = $fragment->parse('core/page/section.php');

$output = '
<form action="' . rex_url::currentBackendPage() . '" method="post">
<input type="hidden" name="formsubmit" value="1" />
    ' . $output . '
</form>
';

echo $output;
