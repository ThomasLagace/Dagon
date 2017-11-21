<?php
require_once('includes/core.php');
header('HTTP/1.0 403 Forbidden');
echo "<p>Error " . http_response_code() . "<p>Level: " . (key_exists('level', $_SESSION) ? $_SESSION['level'] : 'N/A') . "</p>";
