<?php
require_once 'settings.inc.php';

function redirect($url, $permanent = false)
{
    exit(header('Location: ' . $url, $permanent ? 301 : 302));
    return;
}

function createSession($userID, $login, $level, $username = NULL) {
    if (array_key_exists('login', $_SESSION))
       destroySession();
    $_SESSION['login']    = $login;
    $_SESSION['userID']   = $userID;
    $_SESSION['level']    = $level;
    if (is_null($username)) {
        $_SESSION['username'] = $login;
    }
    else $_SESSION['username'] = $username;
    redirect('/');
    return;
}

function destroySession() {
    session_unset();
    session_destroy();
    redirect('/');
    return;
}

function wallOff($requiredLevel) {
    if ( !isset($_SESSION['level']) || $_SESSION['level'] <= $requiredLevel )
        exit(header('Location: /error.php', 403));
    return;
}

function isHtml($string) {
    if ( $string != strip_tags($string) ) {
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['userID']);
}



