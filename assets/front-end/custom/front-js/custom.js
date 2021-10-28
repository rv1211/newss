$(function() {
    const togglePassword = document.querySelector('#toggle_signup_pwd');
    const password = document.querySelector('input[name="user_password"]');
    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
    const togglePassword_con = document.querySelector('#toggle_signup_pwd_con');
    const password_con = document.querySelector('input[name="user_confirm_password"]');
    togglePassword_con.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password_con.getAttribute('type') === 'password' ? 'text' : 'password';
        password_con.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
});