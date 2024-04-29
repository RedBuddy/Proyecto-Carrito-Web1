
const ver_password = document.querySelector('.ver-password');
const btn_usuarios = document.querySelector('.btn-usuarios');

ver_password.addEventListener('click', (e) => {

    const password_input = document.querySelector(".password");

    if (password_input.type === "password") {
        password_input.type = "text";
    } else {
        password_input.type = "password";
    }
});


btn_usuarios.addEventListener('click', (e) => {
    e.preventDefault();
})