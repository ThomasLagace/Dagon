<html>
    <head>
        <title>Thomas' Blog</title>
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

    <a href="/includes/api.php?do=logout">Unplug</a>

    <p>You are jacked in as: <?php
    session_start();
    if (isset($_SESSION['currentUser']) ) {
        echo $_SESSION['currentUser'];
    } else echo 'nobody' ?> </p>


    </body>
</html>