<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsManagerWithComments extends NewsManager
{
    public $commenttpl;
    
    public function __construct() {
        parent::__construct();
        $this->commenttpl = new Template(rex_path::pluginData('newsmanager', 'comments') . 'views/');
    }
    
    public function getComments($article_id) {
        $comments = [];
        //TODO Hier die Kommentare holen.
        
        $query = ''
                . 'SELECT * '
                . 'FROM ' . rex::getTablePrefix() . 'newsmanager_comments '
                . 'WHERE status = 1 '
                . 'AND `re_article_pid` = ' . $article_id . ' '
                . 'ORDER BY `createdate` DESC';
       
        $result = rex_sql::factory();
        //$result->setDebug();
        $result = $result->setQuery($query);
        
        while ($result->hasNext()) {
            
            $comment = new Comment($result);
            
            array_push($comments, $comment);
            
            $result->next();
        }
        return $comments;
    }
    
    public function getCommentList($article_id, $email = false) {
        
        $commentlist = '';
        $listelements = '';
        
        $comments = $this->getComments($article_id);
        
        foreach ($comments as $comment) {
           
            $suggestions = array('article-comment-view');
            
            $variable_array = array(
                'id' => $comment->getId(),
                'name' => $comment->getName(),
                'comment' => $comment->getComment(),
                'createdate' => $comment->getCreatedate()
            );
            
            $listelements .= $this->commenttpl->render($suggestions, $variable_array);
            
        }
        
        $suggestions = array('article-commentlist-view');
        
        $commentlist .= $this->commenttpl->render($suggestions, array(
            'commentlist' => $listelements
        ));
        
        return $commentlist;
    }
    
    public function getCommentForm($article_id) {
        
        $suggestions = array('article-commentform-view');
        $commentform = $this->commenttpl->render($suggestions, array(
            'article_id' => $article_id 
        ));
        return $commentform;
    }
    
    public static function saveComment() {
        
        $newsmanager = new NewsManagerWithComments();
        
        $headline = '<h3 class="info">' . rex_i18n::msg('comment_new_headline') . '</h3>';
        
        $comment = rex_escape(rex_post('user_comm', 'string'));
        $name = rex_escape(rex_post('user_name', 'string'));
        $email = rex_escape(rex_post('user_email', 'string'));
        $re_article_id = rex_escape(rex_post('re_article_id', 'int'));
        $createdate = date("Y-m-d H:i:s");
        
        $query = ''
                . 'INSERT INTO ' . rex::getTablePrefix() . 'newsmanager_comments '
                . '(re_article_pid, comment, name, email, createdate, status) '
                . 'VALUES (' . $re_article_id . ', "' . $comment . '", "' . $name . '", "' . $email . '", "' . $createdate . '", 0)'; 
        
        rex_sql::factory()->setQuery($query);
        
        // Return
        $suggestions = array('article-comment-view');
            
        $variable_array = array(
            'id' => $re_article_id,
            'name' => $name,
            'comment' => $comment,
            'createdate' => $createdate
        );

        return $headline.$newsmanager->commenttpl->render($suggestions, $variable_array);
    }
    
    public function getCommentJavaScript($jquery_installed = false) {
        
        $output = '';
        if ($jquery_installed == false) {
            $output .= '<script type="text/javascript" src="'. rex::getServer() .'assets/core/jquery.min.js"></script>'.PHP_EOL;
        }
        $output .= '<script type="text/javascript" src="' . rex::getServer() . 'assets/addons/newsmanager/plugins/comments/js/newsmanager-comment.min.js"></script>'.PHP_EOL;
        
        return $output;
    }
    
}