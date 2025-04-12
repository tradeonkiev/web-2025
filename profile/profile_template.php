<div class="profile">
    <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Аватар" class="avatar" />
    <p class="text name"><?= htmlspecialchars($user['name']) ?></p>
    <p class="text description"><?= htmlspecialchars($user['description']) ?></p>
    <div class="counter">
        <img src="../lab4/images/edit_vector.png" alt="Посты" />
        <p class="text"><?= $user['posts_count'] ?> постов</p>
    </div>
</div>