<?php
require_once('includes/core.php');
wallOff(3);
?>
<head>
    <title>Make a post!</title>
</head>
<body>
    <form action="/includes/api.php?do=makepost" method="post">
        <input type="text" name="title" placeholder="Title" required><br>
        <br><textarea rows=36 cols=80 name="body" placeholder="Type your post here!"></textarea><br>
        <br><input type="tags" name="tags" placeholder="CSV Tags"><br>
        <input type="submit">
    </form>
</body>
