document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.post__likes').forEach(likeButton => {
        likeButton.addEventListener('click', async () => {
            const postId = likeButton.dataset.postId;
            const likeIcon = likeButton.querySelector('.post__like-icon');
            const likeCountEl = likeButton.querySelector('.post__like-count');
            const isLiked = likeButton.classList.contains('post__likes--active');
            try {
                const response = await fetch('/api/like_post.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        post_id: postId
                    })
                });

                const data = await response.json();

                if (!response.ok || data.status !== 'success') {
                    throw new Error(data.error || 'Ошибка при обработке лайка');
                }
                
                likeCountEl.textContent = data.likes;
                
                if (data.action === 'added') {
                    likeButton.classList.add('post__likes--active');
                } else {
                    likeButton.classList.remove('post__likes--active');
                }

            } catch (err) {
                console.error('Ошибка:', err);
                alert('Не удалось поставить лайк: ' + err.message);
            }
        });
    });
});
