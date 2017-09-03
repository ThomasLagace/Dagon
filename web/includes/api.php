<?php
require_once('core.php');
if (isset($_GET['do'])) {
    $d = $_GET['do'];
    switch ($d) {
        case "login":
            login($_POST['login'], $_POST['password']);
            redirect('/index.php');
            break;

        case "register":
            if ($_POST['password'] == $_POST['confirmPassword']) {
                register($_POST['login'], $_POST['password'], $_POST['code']);
                redirect('/index.php');
            } else {
                echo "Those passwords aren't the same!!! :(";
            }
            break;

        case "logout":
            destroySession();
            redirect('/');
            break;

        case "makepost":
            if( !isLoggedIn() ) {
                echo "Yer not logged in!";
                break;
            }
            if( isHtml($_POST['title']) || isHtml($_POST['body']) || isHtml($_POST['tags']) ) {
                echo "You musn't have html taggens!";
                break;
            }
            addPost($_SESSION['currentUser'], $_POST['title'], $_POST['body'], $_POST['tags']);
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
