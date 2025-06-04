document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.post__edit').forEach(editButton => {
        editButton.addEventListener('click', async () => {
            window.location.href = `/newpost.php?id=${editButton.dataset.postId}`;
        });
    });
});
