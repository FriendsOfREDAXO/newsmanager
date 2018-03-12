<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsManagerArticle
{

    private $id;
    private $pid;
    private $status;
    private $newsmanager_category_id;
    private $title;
    private $subtitle; 
    private $richtext;
    private $images;
    private $seo_description;
    private $seo_canonical;
    private $clang_id;
    private $author;
    private $createuser;
    private $createdate;
    private $updateuser;
    private $updatedate;
    protected $tpl;
    private $teasertext;
    private $url;

    public function __construct()
    {
        $this->tpl = new Template(rex_path::addonData('newsmanager') . 'views/');
    }
    public function getPid()
    {
        return $this->pid;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getNewsmanager_category_id()
    {
        return $this->newsmanager_category_id;
    }

    public function getTitle()
    {
        return $this->title;
    }
        
        public function getSubtitle()
    {
        return $this->subtitle;  
    }
    public function getRichtext()
    {
        return $this->richtext;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getSeo_description()
    {
        return $this->seo_description;
    }

    public function getSeo_canonical()
    {
        return $this->seo_canonical;
    }

    public function getClang_id()
    {
        return $this->clang_id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getCreateuser()
    {
        return $this->createuser;
    }

    public function getCreatedate()
    {
        return $this->createdate;
    }

    public function getUpdateuser()
    {
        return $this->updateuser;
    }

    public function getUpdatedate()
    {
        return $this->updatedate;
    }

    public function getTeaserText()
    {
        return $this->teasertext;
    }

    public function getUrl()
    {
        return $this->url;
    }
    public function setPid($pid)
    {
        $this->pid = $pid;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setNewsmanager_category_id($newsmanager_category_id)
    {
        $this->newsmanager_category_id = $newsmanager_category_id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setRichtext($richtext)
    {
        $this->richtext = $richtext;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function setSeo_description($seo_description)
    {
        $this->seo_description = $seo_description;
    }

    public function setSeo_canonical($seo_canonical)
    {
        $this->seo_canonical = $seo_canonical;
    }

    public function setClang_id($clang_id)
    {
        $this->clang_id = $clang_id;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setCreateuser($createuser)
    {
        $this->createuser = $createuser;
    }

    public function setCreatedate($createdate)
    {
        $this->createdate = $createdate;
    }

    public function setUpdateuser($updateuser)
    {
        $this->updateuser = $updateuser;
    }

    public function setUpdatedate($updatedate)
    {
        $this->updatedate = $updatedate;
    }

    public function setTeaserText($richtext)
    {
        if (($richtext) && (strpos($richtext, '<hr>'))) { 
            $this->teasertext = str_replace('<hr>', '', substr($richtext, 0, strpos($richtext, '<hr>')));
        } else {     
            $this->teasertext = '<p>' . preg_replace("/[^ ]*$/", '', mb_substr(strip_tags($richtext), 0, 300)).'...</p>';
        }
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getTitleTag($article_id)
    {

        $title_scheme = rex_yrewrite::getDomainByArticleId($article_id)->getTitle();

        $title = $title_scheme;
        $title = str_replace('%T', $this->getTitle(), $title);
        $title = str_replace('%SN', rex::getServerName(), $title);

        return '<title>' . htmlspecialchars($title) . '</title>'; //  lang="de"
    }

    public function getDescriptionTag()
    {
        return '<meta name="description" content="' . $this->getSeo_description() . '">';
    }

    public function getCanonicalUrlTag($article_id)
    {
        if ($this->getSeo_canonical() != "") {
            return '<link rel="canonical" href="' . htmlspecialchars($this->getSeo_canonical()) . '" />';
        } else {
            return '<link rel="canonical" href="' . substr(rex::getServer(), 0, -1) . $this->getUrl() . '" />';
        }
    }

    public function getHrefLangTag($article_id)
    {
        $output = '';
        $query = 'SELECT * '
                . 'FROM `' . rex::getTablePrefix() . 'newsmanager` '
                . 'WHERE `status` = 1 '
                . 'AND id = ' . $article_id;

        $result = rex_sql::factory()->getArray($query);

        foreach ($result as $value) {
            $lang = rex_clang::get($value['clang_id']);
            if ($lang) {
                $output .= '<link rel="alternate" hreflang="' . $lang->getCode() . '" href="' . substr(rex::getServer(), 0, -1) . rex_getUrl('', $lang->getId(), ['newsmanager' => $value['id']]) . '" />' . PHP_EOL;
            }
        }
        return $output;
    }

    public function makeImage($media_name, $mediamanager_type = 'newsmanager')
    {

        $image_output = "";

        $media = rex_media::get($media_name);

        // TODO: Umbauen auf HTML5 Picture Tag
        $image_output .= '<figure>' . PHP_EOL;
        $image_output .= '  <img alt="' . $media->getValue('title') . '" class="responsive" src="index.php?rex_media_type=' . $mediamanager_type . '&rex_media_file=' . $media->getFileName() . '">';

        if ($media->getValue('med_copyright') != "") {
            $image_output .= '<footer><small>' . preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $media->getValue('med_copyright')) . '</small></footer>';
        }
        if ($media->getValue('med_description') != "") {
            $image_output .= '  <figcaption>' . $media->getValue('med_description') . '</figcaption>' . PHP_EOL;
        }

        $image_output .= '</figure>' . PHP_EOL;

        return $image_output;
    }

    public function printArticleTeaser($post, $singleViewArticleId)
    {
        $output = '';


        $image = '';

        $suggestions = array('article-teaser');

        if ($post->getImages() != "") {
            $images = explode(',', $post->getImages());
            $image = $this->makeImage($images[0]);
        }

        $this->setTeaserText($post->getRichtext());

        $output .= $this->tpl->render($suggestions, array(
            'title' => $post->getTitle(),
            'subtitle' => $this->getSubtitle(), 
            'createdate' => strftime('%A, %e. %B %Y', strtotime($post->getCreatedate())),
            'url' => $this->getUrl(),
            'teasertext' => $this->getTeaserText(),
            'image' => $image,
            'author' => $this->getAuthor()
                ));


        return $output;
    }
    public function printArticleTeaserList($post, $newsArticle)
    {
        $output = '';


        $suggestions = array('article-teaser-list');

        
        $output .= $this->tpl->render($suggestions, array(
            'title' => $post->getTitle(),
           'subtitle' => $this->getSubtitle(), 
            'url' => $this->getUrl()
                ));

        return $output;
    }    
}
