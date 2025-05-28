document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const form = e.target;
        const email = form.email.value.trim();
        const password = form.password.value;

        const errorBlock = document.getElementById('error');
        const errorIcon = document.getElementById('errorIcon');

        try {
            const response = await fetch('/api/login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password }),
            });

            if (response.ok) {
                window.location.href = '/profile.php';
            } else {
                const data = await response.json();
                showError(errorBlock, data.error || 'Ошибка авторизации');
                errorIcon.src = '/asset/error-icon1.png';
            }
        } catch (err) {
            showError(errorBlock, 'Ошибка сети или сервера.');
            errorIcon.src = '/asset/error-icon1.png';
        }
    });

    function showError(el, message) {
        document.getElementById('errorMsg').textContent = message;
        el.classList.add('login__error--active');
    }
})