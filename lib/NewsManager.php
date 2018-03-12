<?php

/**
 * Newsmanager Class
 *
 * @author Georg Kaser
 *
 */
class NewsManager
{

    protected $tpl;
    public $news_id_parameter;
    public $category_id_parameter;
    private $rex_get_categoryId;

    public function __construct()
    {
        $this->category_id_parameter = rex_get('category', 'int');
        $this->tpl = new Template(rex_path::addonData('newsmanager') . 'views/');

        $urlData = UrlGenerator::getData();

        if (($urlData) && ($urlData->urlParamKey == 'newsmanager')) {
            $this->news_id_parameter = UrlGenerator::getId();
        }

        if (($urlData) && ($urlData->urlParamKey == 'newsmanager_category')) {
            $this->category_id_parameter = UrlGenerator::getId();
        }
    }
    
    public static function create() {
        
        if (rex_addon::get('newsmanager')->getPlugin('comments')->isAvailable()) {
            $instance = new NewsManagerWithComments();
        } else {
            $instance = new self();
        }
        
        return $instance;
    }

    /**
     * Returns the news id parameter from UrlGenerator
     *
     * @return string id of the newsarticle
     */
    public function getNewsIdParameter()
    {
        return $this->news_id_parameter;
    }

    /**
     * Returns the category id parameter from UrlGenerator
     *
     * @return string ID of the category
     */
    public function getCategoryIdParameter()
    {
        return $this->category_id_parameter;
    }

    /**
     * Returns the result as an rex_sql object
     * @param string $query SQL query string
     * @return rex_sql rex_sql object
     */
    private function getBySql($query)
    {
        $result = rex_sql::factory()->setQuery($query);
        return $result;
    }

    /**
     * Returns the result as an array
     *
     * @param string $query SQL query string
     * @return array rex_sql result as array
     */
    public function getArrayBySql($query)
    {
        $result = rex_sql::factory()->getArray($query);
        return $result;
    }

    /**
     *
     * @param rex_sql $result database result
     * @param string $lang_id language id
     * @return \NewsManagerArticle
     */
    private function initializeArticleObject($result, $lang_id)
    {

        $newsArticle = new NewsManagerArticle();
        
        $newsArticle->setPid($result->getValue('pid'));
        $newsArticle->setId($result->getValue('id'));
        $newsArticle->setStatus($result->getValue('status'));
        $newsArticle->setNewsmanager_category_id($result->getValue('newsmanager_category_id'));
        $newsArticle->setTitle($result->getValue('title'));
        $newsArticle->setSubtitle($result->getValue('subtitle'));    
        $newsArticle->setRichtext($result->getValue('richtext'));
        $newsArticle->setImages($result->getValue('images'));
        $newsArticle->setSeo_description($result->getValue('seo_description'));
        $newsArticle->setSeo_canonical($result->getValue('seo_canonical'));
        $newsArticle->setAuthor($result->getValue('author'));
        $newsArticle->setCreateuser($result->getValue('createuser'));
        $newsArticle->setCreatedate($result->getValue('createdate'));
        $newsArticle->setUpdateuser($result->getValue('updateuser'));
        $newsArticle->setUpdatedate($result->getValue('updatedate'));
        $newsArticle->setUrl(rex_getUrl('', $lang_id, ['newsmanager' => $result->getValue('id')]));

        return $newsArticle;
    }

    /**
     * Returns an array with article objects until a given limit for paging
     *
     * @param string $limit until paging
     * @return array array with article objects
     */
    public function getArticleObjectList($limit)
    {

        $limit = $limit;

        $page = rex_request('offset', 'int');

        if ($page == "") {
            $start = 0;
        } else {
            $start = $page;
        }

        $AND_clause = '';

        $category_id = $this->getCategoryIdParameter();

        if ($category_id != 0) {
            $AND_clause .= 'AND `newsmanager_category_id` LIKE \'%|' . $category_id . '|%\' ';
        };

        $allNewsArticleObjects = [];

        $query = 'SELECT SQL_CALC_FOUND_ROWS * '
                . 'FROM `' . rex::getTablePrefix() . 'newsmanager` '
                . 'WHERE `status` = 1 '
                . $AND_clause
                . 'AND clang_id = ' . rex_clang::getCurrentId() . ' '
                . 'ORDER BY `createdate` DESC '
                . 'LIMIT ' . $start . ', ' . $limit . '';

        $result = $this->getBySql($query);

        while ($result->hasNext()) {
            $newsArticle = $this->initializeArticleObject($result, rex_clang::getCurrentId());

            array_push($allNewsArticleObjects, $newsArticle);

            $result->next();
        }

        $query = 'SELECT FOUND_ROWS()';

        $result = $this->getArrayBySql($query);

        $allNewsArticleObjects['total'] = $result[0]['FOUND_ROWS()'];

        $listView_output = '';

        if (($limit > 0) && ($allNewsArticleObjects['total'] > $limit)) {
            $pagemenu = $this->getPager($allNewsArticleObjects['total'], $limit);
            $listView_output .= $pagemenu;
        }

        $allNewsArticleObjects['pager'] = $listView_output;

        return $allNewsArticleObjects;
    }

    /**
     * Returns NewsManagerArticle from id
     *
     * @param string $newsArticle_id id of the newsarticle
     * @return NewsManagerArticle returns the newsartile object
     */
    public function getArticleById($newsArticle_id)
    {

        $newsArticle = new NewsManagerArticle();

        $query = 'SELECT * '
                . 'FROM `' . rex::getTablePrefix() . 'newsmanager` '
                . 'WHERE `status` = 1 '
                . 'AND id = ' . $newsArticle_id . ' '
                . 'AND clang_id = ' . rex_clang::getCurrentId();

        $result = $this->getBySql($query);

        while ($result->hasNext()) {
            $newsArticle = $this->initializeArticleObject($result, rex_clang::getCurrentId());

            $result->next();
        }

        return $newsArticle;
    }
    

    
    /**
     * Generates a list view of the articles from a template (article-teaser-list-view.php)
     *
     * @param NewsManagerArticle $newsArticle Article object
     * @return string markup of the article teaser list view
     */
    public function printTeaserListView($singleViewArticleId, $limit = 0)
    {
        $TeaserlistView_output = '';
        $teasernewslist = '';

        $suggestions = array('article-teaser-list-view');

        $posts = $this->getArticleObjectList($limit);

        foreach ($posts as $post) {
            if ($post instanceof NewsManagerArticle) {
                $teasernewslist .= $post->printArticleTeaserList($post, $newsArticle);
            }
        }

        $TeaserlistView_output .= $this->tpl->render($suggestions, array(
                     'teasernewslist' => $teasernewslist
            ));

        return '<ul>'.$TeaserlistView_output.'</ul>';
    }
    
           
    

    public function printListView($singleViewArticleId, $limit = 0)
    {
        $listView_output = '';
        $newslist = '';


        $suggestions = array('article-list-view');

        $posts = $this->getArticleObjectList($limit);

        foreach ($posts as $post) {
            if ($post instanceof NewsManagerArticle) {
                $newslist .= $post->printArticleTeaser($post, $singleViewArticleId);
            }
        }

        $listView_output .= $this->tpl->render($suggestions, array(
            'newslist' => $newslist,
            'pager' => $posts['pager']
        ));

        return $listView_output;
    }
    /**
     * Generates the single view of the article from a template (article-single-view.php)
     *
     * @param NewsManagerArticle $newsArticle Article object
     * @return string markup of the article single view
     */
    public function printSingleView($newsArticle)
    {

        $output = '';
        $image = '';

        if ($newsArticle->getId() != null) {
            $suggestions = array('article-single-view');

            if ($newsArticle->getImages() != "") {
                $images = explode(',', $newsArticle->getImages());

                if (count($images) == 1) {
                    $image = $newsArticle->makeImage($images[0]);
                } else {
                    $image = '<div id="images">' . PHP_EOL;
                    foreach ($images as $key => $value) {
                        $image .= '<div id="image-' . $key . '" class="image">' . PHP_EOL;
                        $image .= $newsArticle->makeImage($value);
                        $image .= '</div>' . PHP_EOL;
                    }
                    $image .= '</div>' . PHP_EOL;
                }
            }
            if (strpos($newsArticle->getRichtext(), '<hr>')) {
//              $richtext_with_image = str_replace('<hr>', $image, $newsArticle->getRichtext());
                $richtext = str_replace('<hr>', $image, $newsArticle->getRichtext());
            } else {
//              $richtext_with_image = $newsArticle->getRichtext() . $image; // Ausgabe von Text und Bild unabhängig
                $richtext = $newsArticle->getRichtext();   
            }
            $output .= $this->tpl->render($suggestions, array(
                'title' => $newsArticle->getTitle(),
                'subtitle' => $newsArticle->getSubtitle(),
                'createdate' => strftime('%A, %e. %B %Y', strtotime($newsArticle->getCreatedate())),
                'richtext' => $richtext,
                'image' => $image,
                'author' => $newsArticle->getAuthor()
            ));
        } else {
            $suggestions = array('article-error-view');

            $output .= $this->tpl->render($suggestions, array(
                'title' => rex_i18n::rawMsg('newsmanager_error_headline'),
                'error' => rex_i18n::rawMsg('newsmanager_error_no_post')
            ));
        }
        return $output;
    }

    /**
     * Generates the Category Menu
     *
     * @return string category menu markup
     */
    public function printCategoryMenu()
    {

        $category_menu = '<div class="subnav hidden-on-mobile">' . PHP_EOL;
        $category_menu .= '<nav id="categories">' . PHP_EOL;
        $category_menu .= ' <ul>' . PHP_EOL;
        $query = 'SELECT *'
                . 'FROM `' . rex::getTablePrefix() . 'newsmanager_categories` '
                . 'WHERE `clang_id` = ' . rex_clang::getCurrentId();

        $result = rex_sql::factory()->setQuery($query);

        while ($result->hasNext()) {
            $current = '';

            if ($this->category_id_parameter == $result->getValue('id')) {
                $current = 'class="rex-current "';
            }

            $category_menu .= '<li ' . $current . '><a href="' . rex_getUrl('', '', ['newsmanager_category' => $result->getValue('id')]) . '">' . $result->getValue('name') . '</a></li>' . PHP_EOL;

            $result->next();
        }

        $category_menu .= ' </ul>' . PHP_EOL;
        $category_menu .= '</nav>' . PHP_EOL;
        $category_menu .= '</div>' . PHP_EOL;

        return $category_menu;
    }

    /**
     * Generates a pager
     *
     * @param int $total all article objects in database
     * @param int $limit rows per page
     * @param int $category_id category id if available
     * @return string pager menu markup
     */
    private function getPager($total, $limit)
    {

        $pagemenu = 'pager';

        $suggestions = array('article-pager');

        $pager = new rex_pager($limit, 'offset');
        $pager->setRowCount($total);

        $pagemenu = '<ul>';
        for ($page = $pager->getFirstPage(); $page <= $pager->getLastPage(); ++$page) {
            $class = ($pager->isActivePage($page)) ? ' active' : '';
            if ($this->category_id_parameter) {
                $pagemenu .= '<li>
                    <a class="'. $class .'" href="' . rex_getUrl(rex_article::getCurrentId(), '', [$pager->getCursorName() => $pager->getCursor($page), 'category' => $this->category_id_parameter]) . '">' . ($page + 1) . '</a></li>';
            } else {
                $pagemenu .= '<li><a class="'. $class .'" href="' . rex_getUrl(rex_article::getCurrentId(), '', [$pager->getCursorName() => $pager->getCursor($page)]) . '">' . ($page + 1) . '</a></li>';
            }
        }

        $pagemenu .= '</ul>';

        $this->tpl->render($suggestions, array(
            'pager' => $pagemenu
        ));

        return $pagemenu;
    }
    
    public static function getRssHeaderLink() {
        
        return '<link rel="alternate" type="application/rss+xml" title="' . rex::getServerName() . ' RSS-Feed" href="' . rex::getServer() . 'rss-feed-' . rex_clang::getCurrent()->getCode() . '.xml" />';
        
    }
    /**
     * Generates a RSS Feed file for all available online languages
     */
    public static function generateRssFeeds()
    {
        $newsmanager = new NewsManager();
        if (count(rex_clang::getAll()) >= 1) {
            foreach (rex_clang::getAll() as $key => $lang) {
                if ($lang->isOnline()) {
                    $newsmanager->generateRssFeed($lang);
                }
            }
        }
    }
    /**
     * Builds the RSS feed and save it to the root directory of the project
     *
     * @param rex_clang $lang
     */
    private function generateRssFeed($lang)
    {

        $xml = new DOMDocument('1.0', 'utf-8');
        $xml->formatOutput = true;

        $rss = $xml->createElement('rss');
        $rss->setAttribute('version', '2.0');
        $xml->appendChild($rss);

        $channel = $xml->createElement('channel');
        $rss->appendChild($channel);

        // Head des Feeds
        $head_title = $xml->createElement('title', rex::getServerName() . ' RSS Feed');
        $channel->appendChild($head_title);

        $head_description = $xml->createElement('description', rex::getServerName() . ' RSS Feed');
        $channel->appendChild($head_description);

        $head_language = $xml->createElement('language', $lang->getCode());
        $channel->appendChild($head_language);

        $head_link = $xml->createElement('link', rex::getServer());
        $channel->appendChild($head_link);
        
        $articles = $this->getRSSArticleObjects($lang, 20);

        foreach ($articles as $article) {
            if ($article instanceof NewsManagerArticle) {
                $item = $xml->createElement('item');
                $channel->appendChild($item);

                $item_title = $xml->createElement('title', htmlspecialchars($article->getTitle()));
                $item->appendChild($item_title);

                $article->setTeasertext($article->getRichtext());

                $item_description = $xml->createElement('description', htmlspecialchars(strip_tags($article->getTeasertext())));
                $item->appendChild($item_description);

                $item_link = $xml->createElement('link', substr(rex::getServer(), 0, -1) . $article->getUrl());
                $item->appendChild($item_link);

                $item_pubDate = $xml->createElement('pubDate', date("D, d M Y H:i:s O", strtotime($article->getCreatedate())));
                $item->appendChild($item_pubDate);

                $item_guid = $xml->createElement('guid', substr(rex::getServer(), 0, -1) . $article->getUrl());
                $item->appendChild($item_guid);
            }
        }

        $xml->save('../rss-feed-' . $lang->getCode() . '.xml');
    }
    /**
     *
     * @param clang $lang language object
     * @param int $limit limit of the output
     * @return array article objects as array
     */
    private function getRSSArticleObjects($lang, $limit)
    {
        $articleObjects = [];

        $query = 'SELECT * '
                . 'FROM `' . rex::getTablePrefix() . 'newsmanager` '
                . 'WHERE `status` = 1 '
                . 'AND clang_id = ' . $lang->getId() . ' '
                . 'ORDER BY `createdate` DESC '
                . 'LIMIT 0, ' . $limit;

        $result = $this->getBySql($query);

        while ($result->hasNext()) {
            $newsArticle = $this->initializeArticleObject($result, $lang->getId());

            array_push($articleObjects, $newsArticle);

            $result->next();
        }

        return $articleObjects;
    }
}
