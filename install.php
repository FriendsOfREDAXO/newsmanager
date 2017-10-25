<?php

/** @var rex_addon $this */

// Diese Datei ist keine Pflichtdatei mehr.

// SQL-Anweisungen können auch weiterhin über die install.sql ausgeführt werden.

// Abhängigkeiten (PHP-Version, PHP-Extensions, Redaxo-Version, andere Addons/Plugins) sollten in die package.yml eingetragen werden.
// Sie brauchen hier dann nicht mehr überprüft werden!

// Hier können zum Beispiel Konfigurationswerte in der rex_config initialisiert werden.
// Das if-Statement ist notwendig, um bei einem reinstall die Konfiguration nicht zu überschreiben.

if (rex_metainfo_add_field('Copyright', 'med_copyright', '','class="redactorEditor2-mediapool"','2','','','','') != "Der angegebene Spaltenname existiert schon!") {
    rex_delete_cache();
    echo rex_view::success('Das Meta-Info Feld "Copyright" wurde angelegt und der Cache gelöscht!');
}
if (rex_metainfo_add_field('Beschreibung', 'med_description', '','class="redactorEditor2-simple"','2','','','','') != "Der angegebene Spaltenname existiert schon!") {
    rex_delete_cache();
    echo rex_view::success('Das Meta-Info Feld "Beschreibung" wurde angelegt und der Cache gelöscht!');
}

if (!is_dir($this->getDataPath())) {
    rex_dir::copy($this->getPath('data'), $this->getDataPath());
}
