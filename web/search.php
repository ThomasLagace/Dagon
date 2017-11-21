<?php require_once('./includes/BlogPost.php');
    require_once('./includes/core.php');
    require_once('./assets/templates/head.php');
    if(key_exists('q', $_GET) && !empty($_GET['q']))
        $search = $_GET['q']; //Make it so one may change pages in the index
    else redirect('error.php');
?>

<?php require_once('./assets/templates/header.php'); ?>
    <p><a href="/includes/api.php?do=logout">Un_plug</a></p>
    <p>You are jacked in as: <?php //user name here
        if ( !isLoggedIn() ) {
            echo 'nobody</p>';
        } else echo $_SESSION['username'] . " with a level of: " . $_SESSION['level'] . "</p>
            <p><a href='/makepost.php'>Make a post!</a></p>"; 
    ?>
    <section>
        <?php //draw the blog posts
        $r = BlogPost::search($search);
        foreach ($r as $key => $info) {
            require('./assets/templates/posts/listposts.php');
        } ?>
    </section>
<?php require_once('./assets/templates/foot.php'); ?>
