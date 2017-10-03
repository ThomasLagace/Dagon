<?php
require_once("settings.inc.php");
class BlogPost {
    //This class will provide the ability to manipulate blog posts.
    private $title = null;
    private $author = null;
    private $body = null;
    private $tags = null;
    private $id = null;
    private $hidden = null;
    private $deleted = null;
    
    public function __construct($id = NULL) { //By default, it fetches a post with a specified id
        $this->id = $id;
        if (isset($this->id)) {
            print_r($this->fetchPost());
        }

    }

    public function getTitle() {
        return $title;
    }
    public function getAuthor() {
        return $author;
    }
    public function getBody() {
        return $body;
    }
    public function getTags() {
        return $tags;
    }
    public function getId() {
        return $id;
    }
    public function isHidden() {
        return $hidden;
    }
    public function isDeleted() {
        return $deleted;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function setAuthor($author) {
        $this->author = $author;
    }
    public function setBody($body) {
        $this->body = $body;
    }
    public function setTags($tags) {
        $this->tags = $tags;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function addPost() {
        global $db;
        # Check if utilizer has permissions to post
        if (!isset($_SESSION['level']) || $_SESSION['level'] < 3) redirect('/error.php');
        # If so, shove their data into the 'base
        $q = $db->prepare("INSERT INTO posts (author, creation_date, title, body, tags) VALUES (:author, current_date, :title, :body, :tags)");
        $q->bindParam(':author', $this->author);
        $q->bindParam(':title', $this->title);
        $q->bindParam(':body', $this->body);
        $q->bindParam(':tags', $this->tags);
        $q->execute();
    }

    private function fetchPost() {
        global $db;
        $q = $db->prepare("SELECT * FROM posts WHERE id = :id");
        $q->bindParam(':id', $this->id);
        $q->execute();
        if ($q->rowCount() < 1) return "No posts can be shown!";
        $r = $q->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    public function delPost($permanent = false) {
        global $db;
        if (!$permanent) {
            $q = $db->prepare("UPDATE posts SET (deleted, hidden) = (TRUE, TRUE) WHERE id = :id");
            $q->bindParam(':id', $this->id);
            $q->execute();
        } else {
            $q = $db->prepare("DELETE FROM posts WHERE id = :id");
            $q->bindParam(':id', $this->id);
            $q->execute();
        } 
    }

}
