<?php require_once('./includes/BlogPost.php');
    require_once('./includes/core.php');
?>
<html>
    <head>
        <title>Thomas' Blog</title>
<style>
body {
    background-color: #111111;
    color: #eeeeee;
}
</style>
    </head>

    <body>

    <p>This is an early development blog. Login to the form below.</p>
    <form action="/includes/api.php?do=login" method="post">
        <input type="text" name="login" placeholder="Login Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <br>
    <form action="/includes/api.php?do=register" method="post">
        <input type="text" name="login" placeholder="Requested Login Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
        <input type="text" name="code" placeholder="Access Code">
        <input type="submit" value="Register">
    </form>

    <a href="/includes/api.php?do=logout">Un_plug</a>
    <br>
    <a href="/test.php">Testing Function</a>

    <p>You are jacked in as: <?php //user name here
        if (!isset($_SESSION['username']) ) {
            echo 'nobody';
        } else echo $_SESSION['username'] . " with a level of: " . $_SESSION['level'] . "</p>
            <p><a href='/makepost.php'>Make a post!</a></p>"; 
    ?>
    <p>
    <?php 
    $blogPost = new BlogPost(0);
    $r = $blogPost->show(0, 5);
    foreach ($r as $key => $value) {
        echo "<p>" . $value->id . " " .$value->title . " " .$value->body. " " . $value->tags . " " . $value->author . " " . $value->creation_date .  "</p>";
    }
    ?>
    </p>
    </body>
</html>
