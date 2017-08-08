<?php
include('settings.inc.php');

function redirect($url, $external = false, $permanent = false)
{
    $host = '';
    if (!$external)
        $host = $_SERVER['HTTP_HOST'];
    header('Location: ' . $host . $url, true, $permanent ? 301 : 302);
    die();
}

function createSession($user, $level) {
    $_SESSION['user']   = $user;
    $_SESSION['level']  = $level;
    redirect('/');
}

function destroySession() {
    session_unset();
    session_destroy();
    die();
}

function register($login, $password, $code) {
    global $db;
    $passhash = password_hash($password, PASSWORD_DEFAULT);
    # Login code is basically just getting ripped from Jack's Shimapan website. There'll probably be a lot of
    # similarities because Jack is a lot smarter than me at the time being.
    # https://github.com/Foltik/Shimapan/blob/master/includes/core.php
    
    # Check access code
    $q = $db->prepare("SELECT id, used, lvl FROM invites WHERE code = (:code) AND used = FALSE");
    $q->bindParam(':code', $code); 
    $q->execute();
    if ($q->rowCount() == 0) {
        echo "<p>ACCESS DENIED</p>";
        die();
    }
    $r = $q->fetch(PDO::FETCH_ASSOC);

    # Check if username is in use
    $q = $db->prepare("SELECT login FROM utilizers WHERE login = (:login)");
    $q->bindParam(':login', $login);
    $q->execute(); 
    if ($q->rowCount() > 0) {
        echo "<p>LOGIN NAME REGISTER REQUEST DENIED: IN USE</p>";
        die();
    }

    # Create account now
    $q = $db->prepare("INSERT INTO utilizers (login, password, lvl) VALUES (:login, :password, :lvl)");
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
}

function login($login, $password) {
    global $db;

    # Get user's data
    $q = $db->prepare("SELECT password, login, lvl FROM utilizers WHERE login = (:login)");
    $q->bindParam(':login', $login);
    $q->execute();
    $r = $q->fetch();
    if (password_verify($password, $r['password']))
        createSession($r['login'], $r['lvl']);
    else
        echo "<p>rip login lmao</p>";
}
