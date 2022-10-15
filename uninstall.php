<?php

// delete Tables
rex_sql_table::get(rex::getTable('newsmanager'))
    ->drop();
rex_sql_table::get(rex::getTable('newsmanager_categories'))
    ->drop();

// delete Entries in URL Addon

$sql = rex_sql::factory();
$sql->setQuery('DELETE FROM `'.rex::getTable('rex_url_generator_profile').'` WHERE `table_name` = \''.rex::getTable('1_xxx_rex_newsmanager').'\';');
$sql->setQuery('DELETE FROM `'.rex::getTable('rex_url_generator_profile').'` WHERE `table_name` = \''.rex::getTable('1_xxx_rex_newsmanager_categories').'\';');

// Delete directory


if (is_dir($this->getDataPath())) {
    rex_dir::delete($this->getDataPath());
}
