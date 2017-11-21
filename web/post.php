<?php require_once('./includes/BlogPost.php');
    require_once('./includes/core.php');
    require_once('./assets/templates/head.php');
?>

<?php require_once('./assets/templates/header.php'); ?>
    <a href="/includes/api.php?do=logout">Un_plug</a>
    <br />
    <p>You are jacked in as: <?php //user name here
        if (!isset($_SESSION['username']) ) {
            echo 'nobody</p>';
        } else echo $_SESSION['username'] . " with a level of: " . $_SESSION['level'] . "</p>
            <p><a href='/makepost.php'>Make a post!</a></p>"; 
    ?>
    <section>
        <?php 
        $info = new BlogPost($_GET['id']);
        if ($info->exists())
            require('./assets/templates/posts/singlepost.php');
        else require('./assets/templates/posts/noblogpost.php'); ?>
    </section>
<?php require_once('./assets/templates/foot.php'); ?>
