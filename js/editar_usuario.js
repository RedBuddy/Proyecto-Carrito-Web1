const ver_password = document.querySelector('.ver-password');
const ver_password_new = document.querySelector('.ver-password-new');
const ver_password_confirm = document.querySelector('.ver-password-confirm');

ver_password.addEventListener('click', (e) => {
    const password_input = document.querySelector(".password");

    if (password_input.type === "password") {
        password_input.type = "text";
    } else {
        password_input.type = "password";
    }
});

ver_password_new.addEventListener('click', (e) => {
    console.log('click')
    const password_input = document.querySelector(".password-new");


    if (password_input.type === "password") {
        password_input.type = "text";
    } else {
        password_input.type = "password";
    }
});

ver_password_confirm.addEventListener('click', (e) => {
    console.log('click')
    const password_input = document.querySelector(".password-confirm");


    if (password_input.type === "password") {
        password_input.type = "text";
    } else {
        password_input.type = "password";
    }
});