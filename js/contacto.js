
const btn_enviar = document.querySelector('.enviar');

btn_enviar.addEventListener('click', (e) => {
    e.preventDefault();

    flag = true;

    const nombre = document.querySelector(".nombre").value;
    const email = document.querySelector(".correo").value;
    const msj = document.querySelector(".mensaje").value;

    if (!/^[a-zA-Z\s]+$/.test(nombre)) {
        alert("Nombre inválido. Debe contener solo letras y espacios.");
        flag = false;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Email inválido. Debe tener el formato nombre@dominio.com.");
        flag = false;
    }

    if (msj.trim() === "") {
        alert("El campo de texto es obligatorio.");
        flag = false;
    }

    if (flag == false) {
        return false;
    } else {
        e.target.form.submit();
    }

});

const alerta = () => {
    const nombre = document.querySelector(".nombre").value;
    const email = document.querySelector(".correo").value;
    const msj = document.querySelector(".mensaje").value;
    const mensaje = "Nombre: " + nombre + "\nEmail: " + email + "\nMensaje: " + msj;
    alert(mensaje);
};




