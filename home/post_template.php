<div class="post">
    <div class="userdata">
        <div class="row">
            <img src="<?= $post['user_avatar'] ?>" alt="User" class="avatar" />
            <p class="text"><?= htmlspecialchars($post['user_name']) ?></p>
        </div>
        <img src="../lab4/images/edit_vector.png" alt="Edit" class="edit" />
    </div>
    <div class="contentwrapper">
        <img src="<?= $post['image'] ?>" alt="Content" class="content" />
        <p class="count">1/3</p>
    </div>
    <div class="likes">
        <img src="../lab4/images/like.png" alt="Like" />
        <p><?= $post['likes'] ?></p>
    </div>
    <p class="content">
        <?= htmlspecialchars($post['content']) ?>
        <span class="more">...еще</span>
    </p>
    <p class="time"><?= date('H:i', $post['timestamp'] / 1000) ?></p>
</div>