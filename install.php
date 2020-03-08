<?php

// load db settings from update.php
$addon = rex_addon::get('newsmanager');
$addon->includeFile(__DIR__ . '/update.php');

if (rex_metainfo_add_field('Copyright', 'med_copyright', '','class="redactorEditor2-mediapool"','2','','','','') != "Der angegebene Spaltenname existiert schon!") {
    rex_delete_cache();
    echo rex_view::success('Das Meta-Info Feld "Copyright" wurde angelegt und der Cache gelöscht!');
}
if (rex_metainfo_add_field('Beschreibung', 'med_description', '','class="redactorEditor2-simple"','2','','','','') != "Der angegebene Spaltenname existiert schon!") {
    rex_delete_cache();
    echo rex_view::success('Das Meta-Info Feld "Beschreibung" wurde angelegt und der Cache gelöscht!');
}
if (!is_dir($addon->getDataPath())) {
    rex_dir::copy($this->getPath('data'), $this->getDataPath());
}
