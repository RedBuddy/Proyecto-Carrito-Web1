

const boton_enviar = document.querySelector('.boton-enviar');
// const inputs = document.querySelectorAll('input[type="number"]');

boton_enviar.addEventListener('click', (e) => {
    e.preventDefault();

    flag = true;

    const input1 = document.getElementById('precio');
    const input2 = document.getElementById('stock');

    if (input1.value < 0) {
        alert("El precio no pueden ser menor que 0");
        input1.value = 0;
        flag = false;
    }

    if (input2.value < 0) {
        alert("El stock no pueden ser menor que 0");
        input2.value = 0;
        flag = false;
    }

    if (flag == false) {
        return false;
    } else {
        e.target.form.submit();
    }
});

