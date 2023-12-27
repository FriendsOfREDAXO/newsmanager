# News-Manager

> Der News-Manager wird nicht mehr weiterentwickelt. Nutze stattdessen das Nachfolge-Addon [Neues für REDAXO 5](https://github.com/friendsofredaxo/neues/).

## Migration von News-Manager zu Neues

### Warum der Wechsel?

Das FOR-Addon News-Manager befindet sich nicht mehr in aktiver Entwicklung. Es wurde nur noch bis Ende 2022 gewartet. Potentielle Sicherheitslücken werden nicht mehr geschlossen.

Um die Lücke zu schließen, wird das Addon `Neues` von @alexplus_de zu FriendsOfREDAXO gespendet. Die Weiterentwicklung des Neues ist gesichert. Es wird ständig an die neuesten REDAXO-Versionen angepasst und erweitert.

Ein wesentlicher Vorteil gegenüber dem News Manager ist die Unterstützung von YForm. Damit lassen sich die News-Einträge und Kategorien komfortabel verwalten und erweitern, viele Funktionen von YForm und YOrm können genutzt werden.

Wir danken Alex für die Bereitschaft, das Addon in die Hände von FriendsOfREDAXO zu geben, Alex bleibt Projekt-Lead des Addons. Sowie @schorschy @skerbis und @eace für die Unterstützung bei der Entwicklung.

### Funktions-Parität und Unterschiede

| Was                                  | News Manager `3.0.3`                        | Neues `^4.0`                                               |
| ------------------------------------ | ------------------------------------------- | ---------------------------------------------------------- |
| Letzte Weiterentwicklung und Wartung | ❌ 28. Dez. 2022                             | ✅ aktuell                                                |
| REDAXO Core-Version                  | ab `^5.4`                                    | ab `^5.15`                                                   |
| PHP-Version                          | ab `^5.6`                                    | ab `^7.2`                                                    |
| Addon-Abhängigkeiten                 | URL ab `^2`                                  | URL ab `^2`, YForm ab `^4`, YForm Field ab `^2`              |
| Position im Backend                  | `Addons > News Manager`                      | `Aktuelles` (oben)                                           |
| News-Übersicht                       | ✅ `News Manager > "News anlegen"`           | ✅ `Aktuelles > Einträge`                                   |
| Kategorien                           | ✅ `News Manager > "Kategorien"`             | ✅ `Aktuelles > Kategorien`                                 |
| Kommentare                           | ✅ als Plugin: `News Manager > "Kommentare"` | ❌ nein                                                     |
| Autoren                              | ❌ nein                                      | ✅ `Aktuelles > Autoren`                                    |
| Beiträge zeitgesteuert veröffentlichen | ❌ nein                                      | ✅ ja                                                     |
| Mehrsprachigkeit                     | ✅ `News Manager > (Sprache auswählen)`      | ✅ `Aktuelles > Sprachen`                                   |
| Eigene Felder hinzufügen             | ❌ nein                                      | ✅ ja (via YForm)                                           |
| Dokumentation                        | ✅ als Plugin                                | ✅ `Aktuelles > Hilfe`                                      |
| Einstellungen                        | ❌ nein                                      | ✅ `Aktuelles > Einstellungen`                              |
| WYSIWYG-Editor                       | ✅ ausschließlich `redactor2`                | ✅ frei wählbar (`cke5`, `redactor`, `markitup`, `tinymce`) |
| Backend-Sprachen                     | ✅`de,en,es,se`                              | ✅ `de,en,es,se,fr,it`                                      |
| RSS                                  | ✅ ja                                        | 🚧 in Arbeit                                               |
| Fertige Fragmente                    | ✅ ja                                        | 🚧 in Arbeit                                               |
| Multi-Domain-Unterstützung           | ❌ über Umwege                               | ✅ ja                                                       |
| YOrm-Model                           | ❌ nein                                      | ✅ ja (News-Einträge, Kategorien, Autoren, Sprachen)        |
| CSV-Import                           | ❌ nein                                      | ✅ ja (via YForm)                                           |
| CSV-Export                           | ❌ nein                                      | ✅ ja (via YForm)                                           |
| RESTful API                          | ❌ nein                                      | ✅ ja (via YForm)                                           |

### Automatische Daten-Migration von News Manager zu Neues 4

Es gibt einen eine automatische Migration von News Manager-Einträgen zu Neues 4.

Diese werden bei Installation dieser finalen Version des News Managers ausgeführt. Alternativ müssen folgenden Schritte erfolgen:

### Manuelle Daten-Migration von News Manager zu Neues 4

1. Backup der Datenbank und des Dateisystems
2. `Neues` installieren (`YForm`, `YForm Field`, `URL` müssen bereits installiert und aktiviert sein)
3. Bestehende News-Einträge und Kategorien in Neues importieren
4. Module, Templates und URL-Profile anpassen
5. `News Manager` deinstallieren.

#### SQL-Befehle zur Migration der Daten

> Hinweis: Die Autoren müssen manuell oder mit eigenen Anpassungen übertragen werden, da es hierfür eine eigene Tabelle gibt.

```SQL
INSERT INTO rex_neues_category
    (id, name, image, status, createuser, createdate, updateuser, updatedate)
SELECT 
    pid,
    name,
    '',
    '1', 
    createuser,
    createdate,
    updateuser,
    updatedate
FROM rex_newsmanager_categories;

INSERT INTO rex_neues_entry
    (id, status, name, teaser, description, domain_ids, lang_id, publishdate, author_id, url, image, images, createdate, createuser, updatedate, updateuser)
SELECT 
    pid,
    IF(status=1, '1', '-1'),
    title,
    subtitle,
    richtext,
    '',
    clang_id,
    createdate,
    0,
    seo_canonical,
    '',
    images,
    createdate,
    createuser,
    updatedate,
    updateuser
FROM rex_newsmanager;

INSERT INTO rex_neues_entry_category_rel (entry_id, category_id)
SELECT rex_newsmanager.pid , rex_newsmanager_categories.id
FROM rex_newsmanager
INNER JOIN rex_newsmanager_categories
ON FIND_IN_SET(rex_newsmanager_categories.id, REPLACE(REPLACE(rex_newsmanager.newsmanager_category_id, '|', ','), ' ', '')) > 0;
```

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/newsmanager/assets/screenshot.png)

Dieses AddOn stellt eine einfache Newsverwaltung bereit. Dabei werden die Beiträge in einer eigenen Tabelle abgelegt.

## Lizenz

siehe [LICENSE](https://github.com/FriendsOfREDAXO/newsmanager/blob/master/LICENSE)

## Autor

**Friends Of REDAXO**

* <https://www.redaxo.org>
* <https://github.com/FriendsOfREDAXO>
