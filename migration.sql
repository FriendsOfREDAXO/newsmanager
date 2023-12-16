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
    IF(status=1, '1', '0'),
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
