<?php
rex_sql_table::get(rex::getTable('newsmanager'))
    ->ensureColumn(new rex_sql_column('pid', 'int(10) unsigned', false, null, 'auto_increment'))
    ->ensureColumn(new rex_sql_column('id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('status', 'tinyint(1)', true, '0'))
    ->ensureColumn(new rex_sql_column('newsmanager_category_id', 'varchar(255)', true))
    ->ensureColumn(new rex_sql_column('title', 'varchar(255)', false, ''))
    ->ensureColumn(new rex_sql_column('subtitle', 'varchar(255)', false, ''))
    ->ensureColumn(new rex_sql_column('richtext', 'text', true))
    ->ensureColumn(new rex_sql_column('images', 'text', true))
    ->ensureColumn(new rex_sql_column('seo_title', 'varchar(255)', true))
    ->ensureColumn(new rex_sql_column('seo_description', 'varchar(255)', false, ''))
    ->ensureColumn(new rex_sql_column('seo_canonical', 'varchar(255)', true))
    ->ensureColumn(new rex_sql_column('clang_id', 'int(10)', true))
    ->ensureColumn(new rex_sql_column('author', 'varchar(255)'))
    ->ensureColumn(new rex_sql_column('createuser', 'varchar(255)'))
    ->ensureColumn(new rex_sql_column('createdate', 'datetime'))
    ->ensureColumn(new rex_sql_column('updateuser', 'varchar(255)'))
    ->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
    ->setPrimaryKey('pid')
    ->ensure();

rex_sql_table::get(rex::getTable('newsmanager_categories'))
    ->ensureColumn(new rex_sql_column('pid', 'int(10) unsigned', false, null, 'auto_increment'))
    ->ensureColumn(new rex_sql_column('id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('name', 'varchar(255)', true))
    ->ensureColumn(new rex_sql_column('clang_id', 'int(10)', true))
    ->ensureColumn(new rex_sql_column('createuser', 'varchar(255)'))
    ->ensureColumn(new rex_sql_column('createdate', 'datetime'))
    ->ensureColumn(new rex_sql_column('updateuser', 'varchar(255)'))
    ->ensureColumn(new rex_sql_column('updatedate', 'datetime'))
    ->setPrimaryKey('pid')
    ->ensure();

/* Migrate data from newsmanager to friendsofredaxo\neues */
$query = rex_file::get(rex_path::addon('newsmanager', 'migration.sql'));
rex_sql::factory()->setQuery($query);
