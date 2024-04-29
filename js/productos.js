// const productos = [
//     { id: 1, nombre: `NESCAFÉ® Taster's Choice® Caramel Dark Chocolate`, precio: 150 },
//     { id: 2, nombre: `NESCAFÉ® Taster's Choice® Tostado y Molido`, precio: 250 },
//     { id: 3, nombre: `NESTLÉ® COFFEE MATE® Almendra`, precio: 90 },
//     { id: 4, nombre: `NESTLÉ® COFFEE MATE® Coco`, precio: 90 },
//     { id: 5, nombre: `NESTLÉ® COFFEE MATE® Polvo Extra Cremoso`, precio: 95 },
//     { id: 6, nombre: `NESCAFÉ® Black: Tostado Intenso`, precio: 120 }
// ];

// document.getElementById('elemento').addEventListener('mouseover', function () {
//     document.getElementById('cerrar-sesion').style.display = 'inline'; // Mostrar al pasar el mouse
//     this.classList.add('hover-cerrar');
// });

// document.getElementById('elemento').addEventListener('mouseout', function () {
//     document.getElementById('cerrar-sesion').style.display = 'none'; // Ocultar al quitar el mouse
//     this.classList.remove('hover-cerrar');
// });


// document.getElementById('cerrar-sesion').addEventListener('click', function () {
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', '../php/cerrar_sesion.php', true);
//     xhr.onload = function () {
//         if (xhr.status == 200) {
//             window.location.href = '../index.php';
//         } else {
//             alert('Error al cerrar sesión');
//         }
//     };
//     xhr.send();
// });


// const botoncomprar = document.querySelector('.btn-pago');

// botoncomprar.addEventListener('click', (e) => {
//     e.preventDefault();
// });
