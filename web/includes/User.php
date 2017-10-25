<?php
require_once('./core.php');
// This class will be responsible for pulling up basic utilizer information
class User {
    private $id;
    private $login;
    private $password;
    private $username;
    private $level;
    private $creationDate;
    private $avatar = '/assets/img/user/default.png';

    public function getId() {
        return $this->id;
    }
    public function getLogin() {
        return $this->login;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getLevel() {
        return $this->level;
    }
    public function getCreationDate() {
        return $this->creationDate;
    }
    public function getAvatar() {
        return $this->avatar;
    }

    public function setId($id) {
        $this->id = id;
    }
    public function setLogin($login) {
        $this->login = $login;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setLevel($level) {
        $this->level = $level;
    }
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    
    // Input a username to do user operations
    public function __construct($login) {
        global $db;
        $this->login = $login;
        $q = $db->prepare("SELECT name, avatar, id, lvl FROM utilizers WHERE login = (:login)");
        $q->bindParam(':login', $login);
        $q->execute();
        if ($q->rowCount() > 0) {
            $r = $q->fetch(PDO::FETCH_ASSOC);
            if ( is_null($r['name']) ) {
                $this->username = $login;
            }
            else $this->username = $r['name'];
            $this->level = $r['lvl'];
            $this->avatar = $r['avatar'];
            $this->id = $r['id'];
        }
    }
    
    public function register($password, $code) {
        # Shoutouts to Tim for telling me that global variables are automatically
        # included in the funciton's scope. /s
        global $db;
        # Login code is basically just getting ripped from Jack's Shimapan website. 
        # There'll probably be a lot of
        # similarities because Jack is a lot smarter than me at the time being.
        # https://github.com/Foltik/Shimapan/blob/master/includes/core.php

        if ( isHtml($this->login) ) {
            echo "<p>You cannot have any html tags in your name (cursed hacker...)</p>";
            return;
        }
        # Check access code
        $q = $db->prepare("SELECT id, used, lvl FROM invites WHERE code = (:code) AND used = FALSE");
        $q->bindParam(':code', $code);
        $q->execute();
        if ($q->rowCount() == 0) {
            echo "<p>ACCESS DENIED</p>";
        }
        $r = $q->fetch(PDO::FETCH_ASSOC);

        # Check if username is in use
        $q = $db->prepare("SELECT login FROM utilizers WHERE login = (:login)");
        $q->bindParam(':login', $this->login);
        $q->execute();
        if ($q->rowCount() > 0) {
            echo "<p>LOGIN NAME REGISTER REQUEST DENIED: IN USE</p>";
        }

        # Create account now
        # First, hash the password to store securely in the database
        $passhash = password_hash($password, PASSWORD_DEFAULT);

        $q = $db->prepare("INSERT INTO utilizers (login, password, lvl, creation_date, avatar) VALUES (:login, :password, :lvl, current_date, :avatar)");
        $q->bindParam(':login', $this->login);
        $q->bindParam(':password', $passhash);
        $q->bindParam(':lvl', $r['lvl']);
        $q->bindParam(':avatar', $this->avatar);
        $q->execute();

        # Set access code to be used in db
        $q = $db->prepare("UPDATE invites SET used = (:used), usedby = (:usedby) WHERE code = (:code)");
        $q->bindValue(':used', 'TRUE');
        $q->bindValue(':usedby', $this->login);
        $q->bindValue(':code', $code);
        $q->execute();

        # Set $r to our new utilizer
        $q = $db->prepare("SELECT id, login, lvl FROM utilizers WHERE login = (:login)");
        $q->bindParam(':login', $this->login);
        $q->execute();
        $r = $q->fetch();

        # Jack 'em in (thx jack)
        createSession($r['id'], $r['login'], $r['lvl'], $r['login']); //Stores $r['login'] into $_SESSION['currentUser']
        return;
    }

    public function login($password) {
        global $db;
        # Get user's data
        $q = $db->prepare("SELECT id, password, login, name, lvl FROM utilizers WHERE login = (:login)");
        $q->bindParam(':login', $this->login);
        $q->execute();
        $r = $q->fetch();
        if (password_verify($password, $r['password'])) {
            if ( is_null($r['name']) ) {
                $r['name'] = $this->login;
            }
            createSession($r['id'], $r['login'], $r['lvl'], $r['name']); //Stores $r['login'] into $_SESSION['currentUser']
        } else
            echo "<p>rip login lmao</p>";
        return;
    }
}
