
const ver_password = document.querySelector('.ver-password');
const boton_enviar = document.querySelector('.btn-enviar');

ver_password.addEventListener('click', (e) => {
    const password_input = document.querySelector(".password");

    if (password_input.type === "password") {
        password_input.type = "text";
    } else {
        password_input.type = "password";
    }
});


boton_enviar.addEventListener('click', (e) => {
    e.preventDefault();
    remover_clase();

    flag = true;

    const nombre = document.querySelector(".nombre").value;
    const edad = document.querySelector(".edad").value;
    const email = document.querySelector(".email").value;
    const usuario = document.querySelector(".usuario").value;

    const div_nombre = document.querySelector('.div-nombre');
    const div_edad = document.querySelector('.div-edad');
    const div_email = document.querySelector('.div-email');
    const div_usuario = document.querySelector('.div-usuario');

    if (!/^[a-zA-Z\s]+$/.test(nombre)) {
        // i_nombre.classList.add('inputerror');
        if (!div_nombre.querySelector('p')) {
            div_nombre.innerHTML += '<p>Nombre inválido. Debe contener solo letras y espacios.</p>';
        }
        flag = false;
    }

    if (!/^(?:[1-9][0-9]?|1[01][0-9]|120)$/.test(edad)) {
        // i_edad.classList.add('inputerror');
        if (!div_edad.querySelector('p')) {
            div_edad.innerHTML += '<p>Edad inválida. Debe ser un número mayor a 0 y menor a 120.</p>';
        }
        flag = false;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        if (!div_email.querySelector('p')) {
            // i_email.classList.add('inputerror');
            div_email.innerHTML += '<p>Email inválido. Debe tener el formato nombre@dominio.com.</p>';
        }
        flag = false;
    }

    if (!/^[a-zA-Z0-9]{5,}$/.test(usuario)) {
        // i_usuario.classList.add('inputerror');
        if (!div_usuario.querySelector('p')) {
            div_usuario.innerHTML += '<p>Usuario inválido. Debe contener solo letras y números, y tener al menos 5 caracteres.</p>';
        }
        flag = false;
    }


    if (flag == false) {
        return false;
    } else {
        e.target.form.submit();
    }

    // encriptar_contra(password).then(hash => {
    //     alert(`Formulario llenado correctamente \nContraseña: ${password}\nContraseña encriptada: ${hash}`);
    // });


});




const remover_clase = () => {
    const div_nombre = document.querySelector('.div-nombre');
    const div_edad = document.querySelector('.div-edad');
    const div_email = document.querySelector('.div-email');
    const div_usuario = document.querySelector('.div-usuario');

    eliminarParrafos(div_nombre);
    eliminarParrafos(div_edad);
    eliminarParrafos(div_email);
    eliminarParrafos(div_usuario);
};

// const encriptar_contra = (password) => {
//     const encoder = new TextEncoder();
//     const data = encoder.encode(password);
//     return window.crypto.subtle.digest('SHA-256', data).then(hash => {
//         let hexString = '';
//         const view = new DataView(hash);
//         for (let i = 0; i < hash.byteLength; i += 4) {
//             const value = view.getUint32(i);
//             hexString += value.toString(16).padStart(8, '0');
//         }
//         return hexString;
//     });
// }

function eliminarParrafos(div) {
    const parrafos = div.querySelectorAll('p');
    parrafos.forEach(function (parrafo) {
        div.removeChild(parrafo);
    });
}


