# News-Manager

⚠️ Der News-Manager wird nicht mehr weiterentwickelt. 

Dieses AddOn stellt eine einfache Newsverwaltung bereit. Dabei werden die Beiträge in einer eigenen Tabelle abgelegt.

Nutze stattdessen das Nachfolge-Addon [Neues für REDAXO 5](https://github.com/friendsofredaxo/neues/).

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/newsmanager/assets/screenshot.png)

## Lizenz

siehe [LICENSE](https://github.com/FriendsOfREDAXO/newsmanager/blob/master/LICENSE)

## Autor

**Friends Of REDAXO**

* [https://www.redaxo.org](https://www.redaxo.org)
* [https://github.com/FriendsOfREDAXO]([https://github.com/FriendsOfREDAXO)

<hr>

## Hinweise zur Migration zum Neues-AddOn

### Automatische Daten-Migration von News Manager zu Neues 4

Es gibt einen eine automatische Migration von News Manager-Einträgen zu Neues 4.
Diese werden bei Installation dieser finalen Version des News Managers ausgeführt. 

### Manuelle Mifgration 

**Alternativ müssen folgenden Schritte erfolgen:**

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

