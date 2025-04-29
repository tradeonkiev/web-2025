<div class="post-container">
    <img src="<?= htmlspecialchars($post['image']) ?>" alt="post" class="post__image" />
    <div class="post__content">
        <h3 class="post__title"><?= htmlspecialchars($post['title']) ?></h3>
        <h4 class="post__subtitle"><?= htmlspecialchars($post['subtitle']) ?></h4>
        <p class="post__text"><?= htmlspecialchars($post['content']) ?></p>
        <small class="post__date"><?= htmlspecialchars($post['posted_at']) ?></small>
    </div>
</div>
