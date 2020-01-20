<?php

// delete Tables
rex_sql_table::get(rex::getTable('newsmanager'))
    ->drop();
rex_sql_table::get(rex::getTable('newsmanager_categories'))
    ->drop();

if (is_dir($this->getDataPath())) {
    rex_dir::delete($this->getDataPath());
}
