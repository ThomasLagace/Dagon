<?php
require_once('core.php');
if (isset($_GET['do'])) {
    $d = $_GET['do'];
    switch ($d) {
        case "login":
            login($_POST['login'], $_POST['password']);
            break;

        case "register":
            register($_POST['login'], $_POST['password'], $_POST['code']);
            break;
    }
}
else {
    echo "<p>Ya' need some sorta args ya' doofus</p>";
}
