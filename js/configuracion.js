function init() {
    var colorFondoCookie = getCookie("colorFondo");
    if (colorFondoCookie) {
        document.body.style.backgroundColor = colorFondoCookie;
    }
    
    var colorEnlacesCookie = getCookie("colorEnlaces");
    if (colorEnlacesCookie) {
        var enlaces = document.getElementsByTagName("a");
        for (var i = 0; i < enlaces.length; i++) {
            enlaces[i].style.color = colorEnlacesCookie;
        }
    }
    
    var colorFondoEnlacesCookie = getCookie("colorFondoEnlaces");
    if (colorFondoEnlacesCookie) {
        var enlaces = document.getElementsByTagName("a");
        for (var i = 0; i < enlaces.length; i++) {
            enlaces[i].style.backgroundColor = colorFondoEnlacesCookie;
        }
    }

    var redondearEnlacesCookie = getCookie("redondearEnlaces");
    if (redondearEnlacesCookie === "true") {
        redondearEnlaces();
    }
    var tamanoImagenesCookie = getCookie("tamanoImagenes");
    if (tamanoImagenesCookie) {
        if (tamanoImagenesCookie === "chicas") {
            establecerImagenesChicas();
        } else if (tamanoImagenesCookie === "medianas") {
            establecerImagenesMedianas();
        } else if (tamanoImagenesCookie === "grandes") {
            establecerImagenesGrandes();
        }
    }
   
    var bordesCookie = getCookie("bordes");
    if (bordesCookie) {
        if (bordesCookie === "delgados") {
            agregarBordesDelgados();
        } else if (bordesCookie === "ninguno") {
            eliminarBordes();
        }
    }
    var tamanoBordesCookie = getCookie("tamanoBordes");
    if (tamanoBordesCookie) {
        if (tamanoBordesCookie === "pequenos") {
            establecerBordesPequenos();
        } else if (tamanoBordesCookie === "medianos") {
            establecerBordesMedianos();
        } else if (tamanoBordesCookie === "grandes") {
            establecerBordesGrandes();
        }
    }
    var colorBordeCookie = getCookie("colorBorde");
    if (colorBordeCookie) {
        var imagenes = document.getElementsByTagName("img");
        for (var i = 0; i < imagenes.length; i++) {
            imagenes[i].style.borderColor = colorBordeCookie;
        }
    }
    var sombraCookie = getCookie("sombra");
    if (sombraCookie === "true") {
        agregarSombra();
    }
    var colorBordeTablaCookie = getCookie("colorBordeTabla");
    if (colorBordeTablaCookie) {
        var tablas = document.getElementsByTagName("table");
        for (var i = 0; i < tablas.length; i++) {
            tablas[i].style.borderColor = colorBordeTablaCookie;
        }
    }
    var colorFondoTablaCookie = getCookie("colorFondoTabla");
    if (colorFondoTablaCookie) {
        var tablas = document.getElementsByTagName("table");
        for (var i = 0; i < tablas.length; i++) {
            tablas[i].style.backgroundColor = colorFondoTablaCookie;
        }
    }
    var colorCeldasTituloCookie = getCookie("colorCeldasTitulo");
    if (colorCeldasTituloCookie) {
        var titulos = document.querySelectorAll("th");
        for (var i = 0; i < titulos.length; i++) {
            titulos[i].style.backgroundColor = colorCeldasTituloCookie;
        }
    }
    
    var colorFuenteCookie = getCookie("colorFuente");

    if (colorFuenteCookie) {
        var elementosTexto = document.querySelectorAll("body *");
        for (var i = 0; i < elementosTexto.length; i++) {
            elementosTexto[i].style.color = colorFuenteCookie;
        }
    }
    var tamanioFuenteCookie = getCookie("tamanioFuente");

    if (tamanioFuenteCookie) {
        var elementosTexto = document.querySelectorAll("body *");
        for (var i = 0; i < elementosTexto.length; i++) {
            elementosTexto[i].style.fontSize = tamanioFuenteCookie;
        }
    }
    var colorFondoTextoCookie = getCookie("colorFondoTexto");

    if (colorFondoTextoCookie) {
        

        var parrafos = document.querySelectorAll("p");
        parrafos.forEach(function(parrafo) {
            parrafo.style.backgroundColor = colorFondoTextoCookie;
        });

        var titulos = document.querySelectorAll("h1, h2, h3");
        titulos.forEach(function(titulo) {
            titulo.style.backgroundColor = colorFondoTextoCookie;
        });

        var subtitulos = document.querySelectorAll("h4, h5, h6");
        subtitulos.forEach(function(subtitulo) {
            subtitulo.style.backgroundColor = colorFondoTextoCookie;
        });
    }
    var redondearEsquinasImagenesCookie = getCookie("redondearEsquinasImagenes");
    if (redondearEsquinasImagenesCookie) {
        if (redondearEsquinasImagenesCookie === "chico") {
            redondearEsquinasChico();
        } else if (redondearEsquinasImagenesCookie === "mediano") {
            redondearEsquinasMediano();
        } else if (redondearEsquinasImagenesCookie === "grande") {
            redondearEsquinasGrande();
        }
    }


    
    

















}

function cambiarColorFondo() {
    var colorFondo = document.getElementById("colorInput").value;
    document.body.style.backgroundColor = colorFondo;
    document.cookie = "colorFondo=" + colorFondo + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

function cambiarColorEnlaces() {
    var colorEnlaces = document.getElementById("colorInputEnlaces").value;
    var enlaces = document.getElementsByTagName("a");
    for (var i = 0; i < enlaces.length; i++) {
        enlaces[i].style.color = colorEnlaces;
    }
    document.cookie = "colorEnlaces=" + colorEnlaces + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

function cambiarColorFondoEnlaces() {
    var colorFondoEnlaces = document.getElementById("colorFondoInputEnlaces").value;
    var enlaces = document.getElementsByTagName("a");
    for (var i = 0; i < enlaces.length; i++) {
        enlaces[i].style.backgroundColor = colorFondoEnlaces;
    }
    document.cookie = "colorFondoEnlaces=" + colorFondoEnlaces + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

function redondearEnlaces() {
    var enlaces = document.getElementsByTagName("a");
    for (var i = 0; i < enlaces.length; i++) {
        enlaces[i].style.borderRadius = "10rem"; // Redondear los enlaces
    }
    // Guardar el estado de redondear los enlaces en una cookie
    document.cookie = "redondearEnlaces=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

function desredondearEnlaces() {
    var enlaces = document.getElementsByTagName("a");
    for (var i = 0; i < enlaces.length; i++) {
        enlaces[i].style.borderRadius = "0"; // Desredondear los enlaces
    }
    // Eliminar la cookie que indica que los enlaces están redondeados
    document.cookie = "redondearEnlaces=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
function establecerImagenesChicas() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.width = "40px"; // Cambiar el ancho de la imagen
        imagenes[i].style.height = "40px"; // Cambiar la altura de la imagen
    }
    // Guardar el tamaño de las imágenes como "chicas" en una cookie
    document.cookie = "tamanoImagenes=chicas; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

// Función para establecer el tamaño de las imágenes como medianas
function establecerImagenesMedianas() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.width = "90px"; // Cambiar el ancho de la imagen
        imagenes[i].style.height = "90px"; // Cambiar la altura de la imagen
    }
    // Guardar el tamaño de las imágenes como "medianas" en una cookie
    document.cookie = "tamanoImagenes=medianas; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

// Función para establecer el tamaño de las imágenes como grandes
function establecerImagenesGrandes() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.width = "150px"; // Cambiar el ancho de la imagen
        imagenes[i].style.height = "150px"; // Cambiar la altura de la imagen
    }
    // Guardar el tamaño de las imágenes como "grandes" en una cookie
    document.cookie = "tamanoImagenes=grandes; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function agregarBordesDelgados() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.border = "1px solid black"; // Añadir un borde delgado
    }
    // Guardar el borde delgado en una cookie
    document.cookie = "bordes=delgados; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function eliminarBordes() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.border = "none"; // Eliminar el borde
    }
    // Guardar la eliminación de bordes en una cookie
    document.cookie = "bordes=ninguno; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerBordesPequenos() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.borderWidth = ".5rem"; // Ancho del borde pequeño
    }
    // Guardar el tamaño de los bordes en una cookie
    document.cookie = "tamanoBordes=pequenos; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

// Función para establecer bordes medianos en las imágenes
function establecerBordesMedianos() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.borderWidth = "3rem"; // Ancho del borde mediano
    }
    // Guardar el tamaño de los bordes en una cookie
    document.cookie = "tamanoBordes=medianos; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

// Función para establecer bordes grandes en las imágenes
function establecerBordesGrandes() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.borderWidth = ".5rem"; // Ancho del borde grande
    }
    // Guardar el tamaño de los bordes en una cookie
    document.cookie = "tamanoBordes=grandes; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerColorBorde() {
    var colorBorde = document.getElementById("colorBordeInput").value;
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.borderColor = colorBorde; // Establecer el color del borde
    }
    // Guardar el color del borde en una cookie
    document.cookie = "colorBorde=" + colorBorde + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function agregarSombra() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.boxShadow = "10px 10px 20px rgba(0, 0, 0, 0.7)"; // Agregar sombra
    }
    // Guardar el estado de la sombra en una cookie
    document.cookie = "sombra=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

// Función para eliminar la sombra de las imágenes
function eliminarSombra() {
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.boxShadow = "none"; // Eliminar sombra
    }
    // Guardar el estado sin sombra en una cookie
    document.cookie = "sombra=false; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerColorBordeTabla() {
    var colorBordeTabla = document.getElementById("colorBordeTablaInput").value;
    var tablas = document.getElementsByTagName("table");
    for (var i = 0; i < tablas.length; i++) {
        tablas[i].style.borderColor = colorBordeTabla; // Establecer el color de los bordes de la tabla
    }
    // Guardar el color de los bordes de la tabla en una cookie
    document.cookie = "colorBordeTabla=" + colorBordeTabla + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerColorFondoTabla() {
    var colorFondoTabla = document.getElementById("colorFondoTablaInput").value;
    var tablas = document.getElementsByTagName("table");
    for (var i = 0; i < tablas.length; i++) {
        tablas[i].style.backgroundColor = colorFondoTabla; // Establecer el color de fondo de la tabla
    }
    // Guardar el color de fondo de la tabla en una cookie
    document.cookie = "colorFondoTabla=" + colorFondoTabla + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerColorCeldasTitulo() {
    var colorCeldasTitulo = document.getElementById("colorCeldasTituloInput").value;
    var titulos = document.querySelectorAll("th");
    for (var i = 0; i < titulos.length; i++) {
        titulos[i].style.backgroundColor = colorCeldasTitulo; // Establecer el color de las celdas de los títulos
    }
    // Guardar el color de las celdas de los títulos en una cookie
    document.cookie = "colorCeldasTitulo=" + colorCeldasTitulo + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerColorFuente() {
    var colorFuente = document.getElementById("colorFuenteInput").value;
    var elementosTexto = document.querySelectorAll("body *");
    for (var i = 0; i < elementosTexto.length; i++) {
        elementosTexto[i].style.color = colorFuente; // Establecer el color de la fuente para cada elemento de texto
    }
    // Guardar el color de la fuente en una cookie
    document.cookie = "colorFuente=" + colorFuente + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerTamanioFuente(tamanio) {
    var elementosTexto = document.querySelectorAll("body *");
    for (var i = 0; i < elementosTexto.length; i++) {
        elementosTexto[i].style.fontSize = tamanio; // Establecer el tamaño de la fuente para cada elemento de texto
    }
    // Guardar el tamaño de la fuente en una cookie
    document.cookie = "tamanioFuente=" + tamanio + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function establecerColorFondoTexto() {
    // Obtener el valor de color del input
    var color = document.getElementById("colorFondoTextoInput").value;

    // Cambiar el color de fondo de los párrafos
    var parrafos = document.querySelectorAll("p");
    parrafos.forEach(function(parrafo) {
        parrafo.style.backgroundColor = color;
    });

    // Cambiar el color de fondo de los títulos
    var titulos = document.querySelectorAll("h1, h2, h3");
    titulos.forEach(function(titulo) {
        titulo.style.backgroundColor = color;
    });

    // Cambiar el color de fondo de los subtítulos
    var subtitulos = document.querySelectorAll("h4, h5, h6");
    subtitulos.forEach(function(subtitulo) {
        subtitulo.style.backgroundColor = color;
    });

    // Guardar el color de fondo de texto en una cookie
    document.cookie = "colorFondoTexto=" + color + "; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}
function redondearEsquinasChico() {
    var radio = "10rem";
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.borderRadius = radio;
    }
    // Guardar el estado de redondear las esquinas de las imágenes como chico en una cookie
    document.cookie = "redondearEsquinasImagenes=chico; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

// Función para redondear las esquinas de las imágenes como mediano
function redondearEsquinasMediano() {
    var radio = "20rem";
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.borderRadius = radio;
    }
    // Guardar el estado de redondear las esquinas de las imágenes como mediano en una cookie
    document.cookie = "redondearEsquinasImagenes=mediano; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}

// Función para redondear las esquinas de las imágenes como grande
function redondearEsquinasGrande() {
    var radio = "30rem";
    var imagenes = document.getElementsByTagName("img");
    for (var i = 0; i < imagenes.length; i++) {
        imagenes[i].style.borderRadius = radio;
    }
    // Guardar el estado de redondear las esquinas de las imágenes como grande en una cookie
    document.cookie = "redondearEsquinasImagenes=grande; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
}


function restablecerConfiguracion() {
    // Eliminar todas las cookies
    var cookies = document.cookie.split("; ");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
    // Recargar la página
    location.reload();
}
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("redondearBtn").addEventListener("click", redondearEnlaces);
    document.getElementById("desredondearBtn").addEventListener("click", desredondearEnlaces);
    document.getElementById("chicasBtn").addEventListener("click", establecerImagenesChicas);
    document.getElementById("medianasBtn").addEventListener("click", establecerImagenesMedianas);
    document.getElementById("grandesBtn").addEventListener("click", establecerImagenesGrandes);
    document.getElementById("bordesDelgadosBtn").addEventListener("click", agregarBordesDelgados);
    document.getElementById("eliminarBordesBtn").addEventListener("click", eliminarBordes);
    document.getElementById("pequenosBtn").addEventListener("click", establecerBordesPequenos);
    document.getElementById("medianosBtn").addEventListener("click", establecerBordesMedianos);
    document.getElementById("grandesBtn").addEventListener("click", establecerBordesGrandes);
    document.getElementById("colorBordeInput").addEventListener("input", establecerColorBorde);
    document.getElementById("sombraBtn").addEventListener("click", agregarSombra);
    document.getElementById("eliminarSombraBtn").addEventListener("click", eliminarSombra);
    document.getElementById("colorBordeTablaInput").addEventListener("input", establecerColorBordeTabla);
    document.getElementById("colorFondoTablaInput").addEventListener("input", establecerColorFondoTabla);
    document.getElementById("colorCeldasTituloInput").addEventListener("input", establecerColorCeldasTitulo);
    document.getElementById("colorFuenteInput").addEventListener("input", establecerColorFuente);
    document.getElementById("tamanioChicoBtn").addEventListener("click", function() {
        establecerTamanioFuente("10px");
    });

    document.getElementById("tamanioMedianoBtn").addEventListener("click", function() {
        establecerTamanioFuente("15px");
    });

    document.getElementById("tamanioGrandeBtn").addEventListener("click", function() {
        establecerTamanioFuente("18px");
    });

    document.getElementById("colorFondoTextoInput").addEventListener("input", function() {
        establecerColorFondoTexto(document.getElementById("colorFondoTextoInput").value);
    });

    document.getElementById("redondearEsquinasChicoBtn").addEventListener("click", redondearEsquinasChico);
    document.getElementById("redondearEsquinasMedianoBtn").addEventListener("click", redondearEsquinasMediano);
    document.getElementById("redondearEsquinasGrandeBtn").addEventListener("click", redondearEsquinasGrande);


    
    
   





    







});

function getCookie(name) {
    var nameEQ = name + "=";
    var cookies = document.cookie.split(';');
    for(var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) == 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}

window.onload = function() {
    init();
   
};


function toggleOpciones(id) {
    var opciones = document.getElementById(id);
    if (opciones.style.display === "none") {
        opciones.style.display = "block";
    } else {
        opciones.style.display = "none";
    }
}