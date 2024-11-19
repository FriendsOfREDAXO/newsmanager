<?php

/** @var rex_addon $this */

// Diese Datei ist keine Pflichtdatei mehr.
//
// Die Datei sollte keine veränderbare Konfigurationen mehr enthalten, um die Updatefähigkeit zu erhalten.
// Stattdessen sollte dafür die rex_config verwendet werden (siehe install.php)

// Klassen und lang-Dateien müssen hier nicht mehr eingebunden werden, sie werden nun automatisch gefunden.

// Addonrechte (permissions) registieren
if (rex::isBackend() && is_object(rex::getUser())) {
    rex_perm::register('newsmanager[]');
    rex_perm::register('newsmanagersettings[]');
}

// Assets werden bei der Installation des Addons in den assets-Ordner kopiert und stehen damit
// öffentlich zur Verfügung. Sie müssen dann allerdings noch eingebunden werden:

// Assets im Backend einbinden
if (rex::isBackend() && rex::getUser()) {

    // Die style.css überall im Backend einbinden
    // Es wird eine Versionsangabe angehängt, damit nach einem neuen Release des Addons die Datei nicht
    // aus dem Browsercache verwendet, sondern frisch geladen wird
    rex_view::addCssFile($this->getAssetsUrl('css/style.css'));

    if (rex_be_controller::getCurrentPagePart(2) == 'main') {
        rex_view::addCssFile($this->getAssetsUrl('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'));
        rex_view::addJsFile($this->getAssetsUrl('js/moment-with-locales.min.js'));
        rex_view::addJsFile($this->getAssetsUrl('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'));
        rex_view::addJsFile($this->getAssetsUrl('js/script-main.js'));
    }
}

rex_extension::register('REX_FORM_SAVED', array('NewsManager', 'generateRssFeeds'), rex_extension::LATE);
rex_extension::register('REX_FORM_DELETED', array('NewsManager', 'generateRssFeeds'), rex_extension::LATE);
rex_extension::register('REX_LIST_GET', array('NewsManager', 'generateRssFeeds'), rex_extension::LATE);
