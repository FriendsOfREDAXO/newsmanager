<?php

// delete Tables
rex_sql_table::get(rex::getTable('newsmanager'))
    ->drop();
rex_sql_table::get(rex::getTable('newsmanager_categories'))
    ->drop();

$sql = rex_sql::factory();
$sql->setQuery('DELETE FROM `'.rex::getTable('url_generate').'` WHERE table = "'.rex::getTable('1_xxx_rex_newsmanager').'"');
$sql->setQuery('DELETE FROM `'.rex::getTable('url_generate').'` WHERE table LIKE "'.rex::getTable('1_xxx_rex_newsmanager_categories').'"');




if (is_dir($this->getDataPath())) {
    rex_dir::delete($this->getDataPath());
}
