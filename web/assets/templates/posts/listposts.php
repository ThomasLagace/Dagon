<?php require_once('vendor/erusev/parsedown/Parsedown.php');
$md = new Parsedown();
?>
<article> 
    <h2><a href="/post.php?id=<?= $info->id ?>"><?= $info->title ?></a></h2>
    <p><?= nl2br($md->text($info->body)) ?> </p>
    <p><?= $info->tags ?></p>
    <footer>
        <p>
        Author: <?= $info->author ?> 
        at <?= $info->creation_date ?> 
        tags: <?php foreach (str_getcsv($info->tags) as $tag): ?>
            <a href="/search.php?q=<?= $tag ?>"><?= $tag ?></a> 
        <?php endforeach; ?>id: <?= $info->id ?>
        </p>
    </footer>
</article>
