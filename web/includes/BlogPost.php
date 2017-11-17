<?php
require_once("settings.inc.php");
class BlogPost {
    //This class will provide the ability to manipulate blog posts.
    public $exists = true;
    public $title = null;
    public $author = null;
    public $body = null;
    public $tags = null;
    public $id = null;
    public $creation_date = null;
    public $hidden = null;
    public $deleted = null;
    
    public function __construct($id = NULL) { //By default, it fetches a post with a specified id
        $this->id = $id;
        if (isset($this->id)) {
            $this->fetchPost($id);
        }
        else {
            $this->exists = false;
        }
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

    public function deletePost($permanent = false) {
        global $db;
        if($permanent) {
            $q = $db->prepare("DELETE FROM posts WHERE id = :id");
            $q->bindParam(':id', $id);
            $q->execute();
        }
        else {
            $q = $db->prepare("UPDATE posts SET deleted = false WHERE id = :id");
            $q->bindParam(':id', $id);
            $q->execute();
        }
        $this->deleted = true;
    }

    private function fetchPost() {
        global $db;
        $q = $db->prepare("SELECT * FROM posts WHERE id = :id");
        $q->bindParam(':id', $this->id);
        $q->execute();
        if ($q->rowCount() < 1) {
           $this->exists = false;
            return $this->exists;
        }
        $r = $q->fetch(PDO::FETCH_ASSOC);
        $this->title = $r['title'];
        $this->body = $r['body'];
        $this->tags = $r['tags'];
        $this->author = $r['author'];
        $this->creation_date = $r['creation_date'];
        return $r;
    }

    public static function show($start, $end) {
        global $db;
        $q = $db->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT :end OFFSET :start");
        $q->bindParam(':start', $start);
        $q->bindParam(':end', $end);
        $q->execute();
        if ($q->rowCount() < 1) {
           $exists = false;
            return "No posts can be shown!";
        }
        return $q->fetchAll(PDO::FETCH_CLASS);
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
