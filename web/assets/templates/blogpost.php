<?php require_once('vendor/erusev/parsedown/Parsedown.php');
$md = new Parsedown();
?>
<article> 
    <h2><a href="/post.php?id=<?= $info->id ?>"><?= $info->title ?></a></h2>
    <p><?= nl2br($md->text($info->body)) ?> </p>
    <p><?= $info->tags ?></p>
    <footer>
        <p>Author: <?= $info->author ?> at <?= $info->creation_date ?> id: <?= $info->id ?></p>
    </footer>
</article>
