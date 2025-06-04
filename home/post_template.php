<div class="post" >
    <div class="post__user">
        <div class="post__user-info">
            <img src="<?= htmlspecialchars($post['user_avatar']) ?>" alt="User" class="post__avatar" />
            <p class="post__username"><?= htmlspecialchars($post['user_name']) ?></p>
        </div>
        <img src="asset/edit_vector.png" alt="Edit" class="post__edit" data-post-id="<?= $post['id'] ?>"/>
    </div>

    <?php if (!empty($post['images'])): ?>
        <div class="post__media slider">
            <?php foreach ($post['images'] as $index => $image): ?>
                <div class="slide" <?= $index === 0 ? 'style="display: block;"' : 'style="display: none;"' ?>>
                    <img src="/images/<?= htmlspecialchars($image) ?>" alt="Content" class="post__media-img clickable-image" />
                </div>
            <?php endforeach; ?>
            <div class="slider__controls">
              <button class="slider__button slider__button--prev">&lt;</button>
              <button class="slider__button slider__button--next">&gt;</button>
            </div>
            <div class="slider__counter">1/<?= count($post['images']) ?></div>
        </div>
    <?php endif; ?>
    
    <button class="post__likes <?= $post['user_liked'] ? 'post__likes--active' : '' ?>" data-post-id="<?= $post['id'] ?>">
        <img src="asset/like.png" alt="Like" class="post__like-icon" />
        <p class="post__like-count"><?= $post['likes'] ?? 0 ?></p>
    </button>

    <div class="post__text-container">
        <p class="post__text"><?= htmlspecialchars($post['content']) ?></p>
        <button class="post__more" style="display: none;">ещё</button>
    </div>

    <p class="post__time"><?= date('H:i', strtotime($post['posted_at'])) ?></p>
</div>