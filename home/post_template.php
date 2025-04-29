<div class="post">
  <div class="post__user">
    <div class="post__user-info">
      <img src="<?= htmlspecialchars($post['user_avatar']) ?>" alt="User" class="post__avatar" />
      <p class="post__username"><?= htmlspecialchars($post['user_name']) ?></p>
    </div>
    <img src="asset/edit_vector.png" alt="Edit" class="post__edit" />
  </div>

  <div class="post__media">
    <img src="<?= htmlspecialchars($post['image_path']) ?>" alt="Content" class="post__media-img" />
    <p class="post__media-count">1/3</p>
  </div>

  <div class="post__likes">
    <img src="asset/like.png" alt="Like" class="post__like-icon" />
    <p class="post__like-count"><?= $post['likes'] ?? 0 ?></p>
  </div>

  <p class="post__text">
    <?= htmlspecialchars($post['content']) ?>
    <span class="post__more">...еще</span>
  </p>

  <p class="post__time"><?= date('H:i', strtotime($post['posted_at'])) ?></p>
</div>

