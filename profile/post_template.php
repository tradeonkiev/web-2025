<div class="post-container">
    <img src="<?= $post['image'] ?>" alt="post" class="pic" />
    <div class="image-text">
        <h3><?= htmlspecialchars($post['title']) ?></h3>
        <h4><?= htmlspecialchars($post['subtitle']) ?></h4>
        <p><?= htmlspecialchars($post['content']) ?></p>
        <small><?= $post['posted_at'] ?></small>
    </div>
</div>