<div class="profile">
    <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Аватар" class="profile__avatar" />
    <p class="profile__text profile__name"><?= htmlspecialchars($user['name']) ?></p>
    <p class="profile__text profile__description"><?= htmlspecialchars($user['description']) ?></p>
    <div class="profile__counter">
        <img src="asset/edit_vector.png" alt="Edit" class="profile__icon" />
        <p class="profile__text"><?= $user['posts_count'] ?> постов</p>
    </div>
</div>
