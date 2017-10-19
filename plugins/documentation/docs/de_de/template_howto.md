# Templateanpassungen
Für die Ausgabe der Listen- und der Artikelansicht benötigen Sie lediglich ein REDAXO Template.

### `<head>`
 
Verwenden Sie folgenden Codeschnipsel **im Headerbereich** Ihres REDAXO Templates:
```
<head>
    <?php
        $newsmanager = new NewsManager();
        $news_id = $newsmanager->getNewsIdParameter(); 

        $seo = new rex_yrewrite_seo();

        $title_tag = $seo->getTitleTag().PHP_EOL;
        $description_tag = $seo->getDescriptionTag().PHP_EOL;
        $robots_tag = $seo->getRobotsTag().PHP_EOL;
        $hreflang_tag = $seo->getHreflangTags().PHP_EOL;
        $canonical_tag = $seo->getCanonicalUrlTag().PHP_EOL;

        if ($news_id) {

            $article_post = $newsmanager->getArticleById($news_id);

            $title_tag = $article_post->getTitleTag($this->getValue('article_id')).PHP_EOL; 
            $description_tag = $article_post->getDescriptionTag().PHP_EOL;
            $canonical_tag = $article_post->getCanonicalUrlTag($this->getValue('article_id')).PHP_EOL;
            $hreflang_tag = $article_post->getHrefLangTag ($article_post->getId()).PHP_EOL;

        }

        echo $title_tag;
        echo $description_tag;
        echo $robots_tag;
        echo $hreflang_tag;
        echo $canonical_tag; 
    ?>
</head>
```

### `<body>`

Für die Ausgabe der jeweiligen Ansichten müssen Sie lediglich folgenden Codeabschnitt in den Body-Bereich Ihres Templates kopieren:

```php
<body>
    <?php                
        // Ausgabe der Newsartikel

        if ($news_id) {

            // Artikel-Ansicht 

            echo '<div class="col-8">'.PHP_EOL;
            echo $newsmanager->printSingleView($article_post);
            echo '</div>'.PHP_EOL;

        } else {

            // Listenansicht

            echo '<header class="col-12">'.PHP_EOL;
            echo '  <div class="grid">'.PHP_EOL;
            echo '      <h1>' . $this->getValue("name") . '</h1>'.PHP_EOL;
            echo '  </div>'.PHP_EOL;
            echo '</header>'.PHP_EOL;

            echo $newsmanager->printListView(null, $this->getValue('article_id'), 3);

        }
    ?>
</body>
```
Sie haben auch noch die Möglichkeit die Kategorien als Menü auszugeben. Verwenden Sie dafür diesen Codeschnipsel:
```
<aside>
    <?php echo $newsmanager->printCategoryMenu(); ?>
</aside>
```