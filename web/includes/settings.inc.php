<?php
session_start();
# Contains database connection code + other various settings 
define('DAG_DB_CONNECT', 'pgsql:host=localhost;port=5432;dbname=dagondb;');
define('DAG_DB_USER', 'wizard');
define('DAG_DB_PASS', 'qweasdzxc3');

try {
    $db = new PDO(DAG_DB_CONNECT, DAG_DB_USER, DAG_DB_PASS);
}
catch(PDOException $e) {
    echo $e->getMessage();
}
