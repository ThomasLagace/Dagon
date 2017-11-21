<?php require_once('./includes/BlogPost.php');
    require_once('./includes/core.php');
    require_once('./assets/templates/head.php');
    $page = 0;
    if(key_exists('pg', $_GET) && $_GET['pg'] > 0)
        $page = $_GET['pg']; //Make it so one may change pages in the index
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
        $r = BlogPost::show($page*5, 5);
        foreach ($r as $key => $info)
            require('./assets/templates/posts/listposts.php'); 
        ?>
    </section>
    <p style="text-align: center">
        <a href="./?pg=<?= $page - 1 ?>">Previous</a>
        <a href="./?pg=<?= $page + 1 ?>">Next</a>
    </p>
<?php require_once('./assets/templates/foot.php'); ?>
