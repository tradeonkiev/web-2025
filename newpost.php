<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /home.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="newpost/styles.css" />
    <title>New Post</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet" />
    <script defer src="js/newpost.js"></script>
</head>
<body>
    <div class="navigation">
        <div class="navigation__item">
            <img class="navigation__image" src="asset/menu_home.png" alt="Home" onclick="redirectToPage('/home')"/>
        </div>
        <div class="navigation__item">
            <img class="navigation__image" src="asset/menu_user.png" alt="Profile" onclick="redirectToPage('/profile?id=1')"/>
        </div>
        <div class="navigation__item">
            <img class="navigation__image" src="asset/menu_plus.png" alt="Plus" onclick="redirectToPage('/home')"/>
        </div>
    </div>
    
    <div class="wrapper">
        <div class="post__setup">
            <div class="image-push">
                <div class="image-push__uploader" id="imageUploader">
                    <p class="image-push__uploader__icon">🖼</p>
                    <button class="image-push__uploader__btn" id="uploadBtnMain">Добавить фото</button>
                </div>
                <div class="slider" id="imageSlider" style="display: none;">
                    <div class="slides-container" id="slidesContainer"></div>
                    <div class="slider__controls">
                        <button class="slider__button slider__button--prev">&lt;</button>
                        <button class="slider__button slider__button--next">&gt;</button>
                    </div>
                    <button class="slider__delete-image-btn" id="deleteButton">×</button>
                    <div class="slider__counter" id="sliderCounter">1 из 1</div>
                </div>
                <button class="image-push__btn-add-image" id="uploadBtnSecondary"> 
                    <img src="asset/plus-square.svg" class="btn-add-image__icon">
                    Добавить фото
                </button>
                <textarea class="image-push__btn-add-description" id="postCaption" placeholder="Добавьте подпись..."></textarea>
            </div>
            <button class="image-push__btn-share" id="shareBtn" disabled>Поделиться</button>
        </div>
    </div>
    <input type="file" id="fileInput" accept="image/*" multiple style="display: none;">
</body>
</html>