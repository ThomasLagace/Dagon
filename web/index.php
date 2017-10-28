<?php require_once('./includes/BlogPost.php');
    require_once('./includes/core.php');
    require_once('./assets/templates/head.php');
?>

<?php require_once('./assets/templates/header.php'); ?>
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
            echo 'nobody</p>';
        } else echo $_SESSION['username'] . " with a level of: " . $_SESSION['level'] . "</p>
            <p><a href='/makepost.php'>Make a post!</a></p>"; 
    ?>
    <div class=mainInfoContainer>
        <?php require_once('./assets/templates/sidebar.php');?>
        <?php 
        $blogPost = new BlogPost(0);
        if (isset($_GET['pg']) && is_int($_GET['pg'])) {
            $r = $blogPost->show(0, 5);
        }
        else $r = $blogPost->show($_GET['pg']*5, 5) ?>

        <?php foreach ($r as $key => $info): ?>
            <?php require('./assets/templates/blogpost.php') ?>
        <?php endforeach ?>
    </div>
    <a href="./?pg=<?= $_GET['pg'] - 1 ?>">Previous</a>
    <a href="./?pg=<?= $_GET['pg'] + 1 ?>">Next</a>
    </body>
<?php require_once('./assets/templates/foot.php'); ?>
