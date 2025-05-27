<div class="post-container">
    <!-- <img src="<?= htmlspecialchars($post['image']) ?>" alt="post" class="post__image" /> -->
    <img src='/images/photo1.jpg' alt="post" class="post__image" /> 
    <div class="post__content">
        <p class="post__text"><?= htmlspecialchars($post['content']) ?></p>
        <small class="post__date"><?= htmlspecialchars($post['posted_at']) ?></small>
    </div>
</div>