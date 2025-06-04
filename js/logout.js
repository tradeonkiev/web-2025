document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.current-user__logout').addEventListener('click', async () => {
        const response = await fetch('/api/logout.php', {
            method: 'POST'
        });
        console.log(response);
        window.location.href = '/home.php';
    });
})