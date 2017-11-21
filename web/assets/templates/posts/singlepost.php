<?php require_once('vendor/erusev/parsedown/Parsedown.php');
$md = new Parsedown();
?>
<article> 
    <h2><a href="/post.php?id=<?= $info->getId() ?>"><?= $info->getTitle() ?></a></h2>
    <?= nl2br($md->text($info->getBody())) ?>
    <footer>
        <p>
        Author: <?= $info->getAuthor() ?> 
        at <?= $info->getCreationDate() ?> 
        id: <?= $info->getId() ?>
        tags: <?php foreach ($info->getTags() as $tag): ?>
            <a href="/search.php?q=<?= $tag ?>"><?= $tag ?></a> 
        <?php endforeach; ?>
        </p>
    </footer>
</article>
