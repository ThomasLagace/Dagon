<?php
require_once('settings.inc.php');

function debug_to_console( $data ) {

	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

	echo $output;
}

function redirect($url, $permanent = false)
{
    exit(header('Location: ' . $url, $permanent ? 301 : 302));
    return;
}

function createSession($user, $level) {
    $_SESSION['currentUser']   = $user;
    $_SESSION['level']         = $level;
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
    return isset($_SESSION['currentUser']);
}

function register($login, $password, $code) {
    # Shoutouts to Tim for telling me that global variables are automatically
    # included in the funciton's scope.
    global $db;
    # Login code is basically just getting ripped from Jack's Shimapan website. There'll probably be a lot of
    # similarities because Jack is a lot smarter than me at the time being.
    # https://github.com/Foltik/Shimapan/blob/master/includes/core.php

    if ( isHtml('currentUser') ) {
        echo "<p>You cannot have any html tags in your name (cursed hacker...)</p>";
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
    $q->bindParam(':login', $login);
    $q->execute();
    if ($q->rowCount() > 0) {
        echo "<p>LOGIN NAME REGISTER REQUEST DENIED: IN USE</p>";
    }

    # Create account now
    # First, hash the password to store securely in the database
    $passhash = password_hash($password, PASSWORD_DEFAULT);

    $q = $db->prepare("INSERT INTO utilizers (login, password, lvl, creation_date) VALUES (:login, :password, :lvl, current_date)");
    $q->bindParam(':login', $login);
    $q->bindParam(':password', $passhash);
    $q->bindParam(':lvl', $r['lvl']);
    $q->execute();

    # Set access code to be used in db
    $q = $db->prepare("UPDATE invites SET used = (:used), usedby = (:usedby) WHERE code = (:code)");
    $q->bindValue(':used', 'TRUE');
    $q->bindValue(':usedby', $login);
    $q->bindValue(':code', $code);
    $q->execute();

    # Jack 'em in (thx jack)
    createSession($login, $r['lvl']);
    return;
}

function login($login, $password) {
    global $db;
    # Get user's data
    $q = $db->prepare("SELECT password, login, lvl FROM utilizers WHERE login = (:login)");
    $q->bindParam(':login', $login);
    $q->execute();
    $r = $q->fetch();
    if (password_verify($password, $r['password'])) {
        createSession($r['login'], $r['lvl']);
    } else
        echo "<p>rip login lmao</p>";
    return;
}


