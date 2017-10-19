<?php

$content = '';
$buttons = '';

if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
        ['newsmanager-page-id', 'array[int]'],
    ]));
    
    if (rex_addon::getConfig('newsmanager-page-id')) {
        $id = rex_addon::getConfig('newsmanager-page-id')[0];
        
        if ($id > 0) {
    
            $article_id = $id;
            $user = rex::getUser()->getLogin();

            if (count(rex_clang::getAll())==1) {      
                $query = "DELETE FROM `rex_url_generate` WHERE `table` = '1_xxx_rex_newsmanager'";
                $result = rex_sql::factory()->setQuery($query);
                $query = "DELETE FROM `rex_url_generate` WHERE `table` LIKE '1_xxx_rex_newsmanager_categories'";
                $result = rex_sql::factory()->setQuery($query);

                $query = "INSERT INTO `rex_url_generate` (`article_id`, `clang_id`, `url`, `table`, `table_parameters`, `relation_table`, `relation_table_parameters`, `relation_insert`, `createdate`, `createuser`, `updatedate`, `updateuser`)
            VALUES
                    ($article_id, 1, '', '1_xxx_rex_newsmanager', '{\"1_xxx_rex_newsmanager_field_1\":\"title\",\"1_xxx_rex_newsmanager_field_2\":\"\",\"1_xxx_rex_newsmanager_field_3\":\"\",\"1_xxx_rex_newsmanager_id\":\"id\",\"1_xxx_rex_newsmanager_clang_id\":\"\",\"1_xxx_rex_newsmanager_restriction_field\":\"\",\"1_xxx_rex_newsmanager_restriction_operator\":\"=\",\"1_xxx_rex_newsmanager_restriction_value\":\"\",\"1_xxx_rex_newsmanager_url_param_key\":\"newsmanager\",\"1_xxx_rex_newsmanager_seo_title\":\"title\",\"1_xxx_rex_newsmanager_seo_description\":\"seo_description\",\"1_xxx_rex_newsmanager_sitemap_add\":\"1\",\"1_xxx_rex_newsmanager_sitemap_frequency\":\"daily\",\"1_xxx_rex_newsmanager_sitemap_priority\":\"1.0\",\"1_xxx_rex_newsmanager_sitemap_lastmod\":\"updatedate\",\"1_xxx_rex_newsmanager_path_names\":\"\",\"1_xxx_rex_newsmanager_path_categories\":\"0\",\"1_xxx_rex_newsmanager_relation_field\":\"\"}', '', '[]', 'before', 2017, '$user', 2017, '$user');";

                $result1 = rex_sql::factory()->setQuery($query); 

                $query = "INSERT INTO `rex_url_generate` (`article_id`, `clang_id`, `url`, `table`, `table_parameters`, `relation_table`, `relation_table_parameters`, `relation_insert`, `createdate`, `createuser`, `updatedate`, `updateuser`)
            VALUES
                    ($article_id, 1, '', '1_xxx_rex_newsmanager_categories', '{\"1_xxx_rex_newsmanager_categories_field_1\":\"name\",\"1_xxx_rex_newsmanager_categories_field_2\":\"\",\"1_xxx_rex_newsmanager_categories_field_3\":\"\",\"1_xxx_rex_newsmanager_categories_id\":\"id\",\"1_xxx_rex_newsmanager_categories_clang_id\":\"\",\"1_xxx_rex_newsmanager_categories_restriction_field\":\"\",\"1_xxx_rex_newsmanager_categories_restriction_operator\":\"=\",\"1_xxx_rex_newsmanager_categories_restriction_value\":\"\",\"1_xxx_rex_newsmanager_categories_url_param_key\":\"newsmanager_category\",\"1_xxx_rex_newsmanager_categories_seo_title\":\"name\",\"1_xxx_rex_newsmanager_categories_seo_description\":\"\",\"1_xxx_rex_newsmanager_categories_sitemap_add\":\"1\",\"1_xxx_rex_newsmanager_categories_sitemap_frequency\":\"always\",\"1_xxx_rex_newsmanager_categories_sitemap_priority\":\"1.0\",\"1_xxx_rex_newsmanager_categories_sitemap_lastmod\":\"updatedate\",\"1_xxx_rex_newsmanager_categories_path_names\":\"\",\"1_xxx_rex_newsmanager_categories_path_categories\":\"0\",\"1_xxx_rex_newsmanager_categories_relation_field\":\"\"}', '', '[]', 'before', 2017, '$user', 2017, '$user');";
                $result2 = rex_sql::factory()->setQuery($query);
            } else {
                $query = "DELETE FROM `rex_url_generate` WHERE `table` = '1_xxx_rex_newsmanager'";
                $result = rex_sql::factory()->setQuery($query);
                $query = "DELETE FROM `rex_url_generate` WHERE `table` LIKE '1_xxx_rex_newsmanager_categories'";
                $result = rex_sql::factory()->setQuery($query);

                $query = "INSERT INTO `rex_url_generate` (`article_id`, `clang_id`, `url`, `table`, `table_parameters`, `relation_table`, `relation_table_parameters`, `relation_insert`, `createdate`, `createuser`, `updatedate`, `updateuser`)
            VALUES
                    ($article_id, 0, '', '1_xxx_rex_newsmanager', '{\"1_xxx_rex_newsmanager_field_1\":\"title\",\"1_xxx_rex_newsmanager_field_2\":\"\",\"1_xxx_rex_newsmanager_field_3\":\"\",\"1_xxx_rex_newsmanager_id\":\"id\",\"1_xxx_rex_newsmanager_clang_id\":\"clang_id\",\"1_xxx_rex_newsmanager_restriction_field\":\"\",\"1_xxx_rex_newsmanager_restriction_operator\":\"=\",\"1_xxx_rex_newsmanager_restriction_value\":\"\",\"1_xxx_rex_newsmanager_url_param_key\":\"newsmanager\",\"1_xxx_rex_newsmanager_seo_title\":\"title\",\"1_xxx_rex_newsmanager_seo_description\":\"seo_description\",\"1_xxx_rex_newsmanager_sitemap_add\":\"1\",\"1_xxx_rex_newsmanager_sitemap_frequency\":\"daily\",\"1_xxx_rex_newsmanager_sitemap_priority\":\"1.0\",\"1_xxx_rex_newsmanager_sitemap_lastmod\":\"updatedate\",\"1_xxx_rex_newsmanager_path_names\":\"\",\"1_xxx_rex_newsmanager_path_categories\":\"0\",\"1_xxx_rex_newsmanager_relation_field\":\"\"}', '', '[]', 'before', 2017, '$user', 2017, '$user');";

                $result = rex_sql::factory()->setQuery($query); 

                $query = "INSERT INTO `rex_url_generate` (`article_id`, `clang_id`, `url`, `table`, `table_parameters`, `relation_table`, `relation_table_parameters`, `relation_insert`, `createdate`, `createuser`, `updatedate`, `updateuser`)
            VALUES
                    ($article_id, 0, '', '1_xxx_rex_newsmanager_categories', '{\"1_xxx_rex_newsmanager_categories_field_1\":\"name\",\"1_xxx_rex_newsmanager_categories_field_2\":\"\",\"1_xxx_rex_newsmanager_categories_field_3\":\"\",\"1_xxx_rex_newsmanager_categories_id\":\"id\",\"1_xxx_rex_newsmanager_categories_clang_id\":\"clang_id\",\"1_xxx_rex_newsmanager_categories_restriction_field\":\"\",\"1_xxx_rex_newsmanager_categories_restriction_operator\":\"=\",\"1_xxx_rex_newsmanager_categories_restriction_value\":\"\",\"1_xxx_rex_newsmanager_categories_url_param_key\":\"newsmanager_category\",\"1_xxx_rex_newsmanager_categories_seo_title\":\"name\",\"1_xxx_rex_newsmanager_categories_seo_description\":\"\",\"1_xxx_rex_newsmanager_categories_sitemap_add\":\"1\",\"1_xxx_rex_newsmanager_categories_sitemap_frequency\":\"always\",\"1_xxx_rex_newsmanager_categories_sitemap_priority\":\"1.0\",\"1_xxx_rex_newsmanager_categories_sitemap_lastmod\":\"updatedate\",\"1_xxx_rex_newsmanager_categories_path_names\":\"\",\"1_xxx_rex_newsmanager_categories_path_categories\":\"0\",\"1_xxx_rex_newsmanager_categories_relation_field\":\"\"}', '', '[]', 'before', 2017, '$user', 2017, '$user');";
                $result = rex_sql::factory()->setQuery($query);
            }

            UrlGenerator::generatePathFile([]);

        }
    }
    if (rex_addon::get('redactor2')->isAvailable()) {
       
        if (!redactor2::profileExists('newsmanager')) {
            redactor2::insertProfile('newsmanager', 'Angelegt durch das News-Manager Addon', '300', '800', 'relative','groupheading[2|3|4|5|6],paragraph,bold, italic, underline,deleted, sub, sup,  unorderedlist, orderedlist,video,media,grouplink[email|external|internal|media|telephone], cleaner,horizontalrule,source,fullscreen');
            echo rex_view::success('Das nötige Redactor2-Profil wurde angelegt');
        }
        
    } else {
        
        echo rex_view::info($this->i18n('settings_error_redactor2'));
        
    }
    

    echo rex_view::success($this->i18n('settings_saved'));

}

$content .= '<fieldset><legend>' . $this->i18n('settings_category') . '</legend>';

$content .= '<p>' . $this->i18n('settings_description') . '</p>';

// Kategorienauswahl

$n = [];
$n['label'] = '<label for="demo_addon-config-categories">' . $this->i18n('settings_category_label') . '</label>';

$category_select = new rex_category_select(false, false, false, true);
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