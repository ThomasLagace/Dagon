<?php
require_once('core.php');
require_once('BlogPost.php');
require_once('User.php');
if (isset($_GET['do'])) {
    $d = $_GET['do'];
    switch ($d) {
        case "login":
            $connect = new User($_POST['login']);
            $connect->login($_POST['password']);
            redirect('/index.php');
            break;

        case "register":
            if ($_POST['password'] == $_POST['confirmPassword']) {
                $addUser = new User($_POST['login']);
                $addUser->register($_POST['password'], $_POST['code']);
                redirect('/');
            } else {
                echo "Those passwords aren't the same!!! :(";
            }
            break;

        case "logout":
            destroySession();
            redirect('/');
            break;

        case "makepost":
            foreach ( $_POST as $key ) $_POST[$key] = htmlspecialchars($key, ENT_QUOTES);
            if( !isLoggedIn() ) {
                echo "Yer not logged in!";
                break;
            }
            $bp = new BlogPost();
            $bp->author = $_SESSION['login'];
            $bp->title = htmlspecialchars($_POST['title'], ENT_QUOTES);
            $bp->body = htmlspecialchars($_POST['body'], ENT_QUOTES);
            $bp->tags = htmlspecialchars($_POST['tags'], ENT_QUOTES);
            $bp->addPost();
            redirect('/');
            break;

        case '':
            echo "Well you called do but did nothing. Are you dull?";
            break;

        default:
            echo "I'm but a dumb computer that can only do what it knows.";
    }
}
else {
    echo "Ya' need some sorta args ya' doofus";
}
