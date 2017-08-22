<?php
header('HTTP/1.0 403 Forbidden');
echo "<p>Error " . http_response_code() . "<p>Level: " . (isset($_SESSION['level']) ? $_SESSION['level'] : 'N/A') . "</p>";
