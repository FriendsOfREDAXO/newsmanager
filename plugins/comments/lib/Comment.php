<?php

class Comment 
{
    
    private $id;
    private $re_article_pid;
    private $comment;
    private $name;
    private $email;
    private $createdate;
    private $status;
    
    public function __construct($result) {
        $this->id = $result->getValue('id');
        $this->re_article_id = $result->getValue('re_article_pid');
        $this->comment = $result->getValue('comment');
        $this->name = $result->getValue('name');
        $this->email = $result->getValue('email');
        $this->createdate = $result->getValue('createdate');
        $this->status = $result->getValue('status');
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getRe_article_pid() {
        return $this->re_article_pid;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCreatedate() {
        return $this->createdate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setRe_article_pid($re_article_pid) {
        $this->re_article_pid = $re_article_pid;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCreatedate($createdate) {
        $this->createdate = $createdate;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}