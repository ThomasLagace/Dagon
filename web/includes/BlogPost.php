<?php
require_once("settings.inc.php");
class BlogPost {
    //This class will provide the ability to manipulate blog posts.
    public $title = null;
    public $author = null;
    public $body = null;
    public $tags = null;
    public $id = null;
    
    public function __construct() {
    }

    function addPost() {
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

    function fetchPost() {
        global $db;
        $q = $db->prepare("SELECT * FROM posts WHERE id = :id");
        $q->bindParam(':id', $this->id);
        $q->execute();
        if ($q->rowCount() < 1) return "No posts can be shown!";
        $r = $q->fetch(PDO::FETCH_ASSOC);
        return $r;
    }
}
