<html>

<head>
<title>Thomas' Blog</title>
</head>

<body>

<p>This is an early developmen blog. Login to the form below.</p>
<form action="./includes/api.php?do=login" method="post">
    <input type="text" name="login" placeholder="Login Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="login">
</form>

<form action="./includes/api.php?do=register" method="post">
    <input type="text" name="login" placeholder="Requested Login Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirmpassword" placeholder="Confirm Password">
    <input type="text" name="code" placeholder="Access Code">
    <input type="submit" value="login">
</form>


</body>
</html>
