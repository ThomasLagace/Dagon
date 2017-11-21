<section class="login">
    <header>
        <h2 style="border-bottom: 2px dotted #202020">Login</h2>
    
    </header>
    <form action="/includes/api.php?do=login" method="post">
        <input type="text" name="login" placeholder="Login Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <br />
    <form action="/includes/api.php?do=register" method="post" class="login">
        <input type="text" name="login" placeholder="Requested Login Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
        <input type="text" name="code" placeholder="Access Code">
        <input type="submit" value="Register">
    </form>
</section>
