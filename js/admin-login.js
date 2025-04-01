document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    const form = document.getElementById('adminLoginForm');
    const errorMessage = document.getElementById('errorMessage');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Credenciais inválidas")) {
                errorMessage.textContent = "Credenciais inválidas!";
                errorMessage.style.display = 'block';
            } else {
                window.location.href = 'admin_panel.html';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            errorMessage.textContent = "Ocorreu um erro ao tentar fazer login. Tente novamente.";
            errorMessage.style.display = 'block';
        });
    });
});