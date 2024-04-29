<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- preload -->
  <!-- <link rel="preload" href="../css/normalize.css" as="style" />
  <link rel="stylesheet" href="../css/normalize.css" /> -->

  <link rel="preload" href="../css/configuracion.css" as="style" />
  <link rel="stylesheet" href="../css/configuracion.css" />

  <!-- Fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Island+Moments&display=swap" rel="stylesheet" />

  <title>Configuracion</title>
</head>

<body>
  <header class="header">
    <a class="header-logo" href="productos.php">
      <img src="../img/cafe.webp" alt="cafe logo" />
      <h1>Café del bosque</h1>
    </a>

    <div class="header-links">
      <a class="link" href="productos.php">Productos</a>
      <a class="link seleccionado" href="configuracion.php">Configuracion</a>
      <a class="link" href="contacto.php">Contacto</a>
      <a class="link" href="informes/historialCompras.php">Historial compras</a>

      <?php

      if (isset($_SESSION['username'])) {
        if ($_SESSION['username'] == 'admin') {
          echo "<a class='link' href='gestion_productos/gestion.php'>Gestión de productos</a>";
          echo "<a class='link' href='informes/ventas.php'>Informes</a>";
        }
      }

      echo "<div id='elemento'>";
      if (isset($_SESSION['username'])) {
        $usuario = $_SESSION['username'];
        echo "<a class='link' href='editar_usuario.php'>$usuario</a>";
      } else {
        echo "<a class='link' href=''>Usuario X</a>";
      }
      echo "<button id='cerrar-sesion' href=''>Cerrar sesión</button>";

      echo "</div>";

      $cantidadProductos = 0;
      if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"])) {
        $cantidadProductos = count($_SESSION["carrito"]);
      }
      echo "<a class='boton btn-carrito' href='carrito.php'>Carrito (<span class='boton-carrito'>{$cantidadProductos}</span>)</a>";
      ?>
    </div>
  </header>

  <div class="banner">
    <div class="subtitulo">
      <h2>Configuracion</h2>
    </div>
    <div class="confi">
      <h4>
        Personaliza tu experiencia dentro de nuestra página web. Sumérgete en
        el mundo del café de alta calidad y descubre la magia de crear tu
        propia experiencia aromática. Personaliza cada detalle para que tu
        taza de café sea verdaderamente tuya.
      </h4>
    </div>
  </div>


  <div class="contenedor-centrado">
    <div class="parametros">
      <h2>Parametros de Configuracion</h2>

    </div>

    <div class="enlaces-configuracion">
      <h3><span class="punto">&#8226;</span> Fondo <button id="boton-fondo" class="flecha" onclick="toggleOpciones('opciones-fondo')">▼</button></h3>
      <div class="opciones-configuracion hidden" id="opciones-fondo">
        <!-- Aquí van las diferentes opciones -->
        <p>
        <div class="fondo">
          <section>
            <h2>Color de Fondo:</h2>
            <input type="color" id="colorInput" onchange="cambiarColorFondo()" />
          </section>
        </div>
        </p>

      </div>
    </div>

    <div class="enlaces-configuracion">
      <h3><span class="punto">&#8226;</span> Enlaces <button id="boton-enlaces" class="flecha" onclick="toggleOpciones('opciones-enlaces')">▼</button></h3>
      <div class="opciones-configuracion hidden" id="opciones-enlaces">
        <!-- Aquí van las diferentes opciones -->
        <div class="fondo">
          <section>
            <h2>Color del Enlace:</h2>
            <input type="color" id="colorInputEnlaces" onchange="cambiarColorEnlaces()" />
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Color del Fondo de los Enlaces:</h2>
            <input type="color" id="colorFondoInputEnlaces" onchange="cambiarColorFondoEnlaces()" />
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Redondeo de Enlaces: :</h2>
            <button class="btn-form" id="redondearBtn">Redondear Enlaces</button>
            <button class="btn-form" id="desredondearBtn">Desredondear Enlaces</button>
          </section>
        </div>
      </div>
    </div>

    <div class="enlaces-configuracion">
      <h3><span class="punto">&#8226;</span> Imágenes <button id="boton-imagenes" class="flecha" onclick="toggleOpciones('opciones-imagenes')">▼</button></h3>
      <div class="opciones-configuracion hidden" id="opciones-imagenes">
        <!-- Aquí van las diferentes opciones -->
        <div class="fondo">
          <section>
            <h2>Tamaño de Imagenes: :</h2>
            <button class="btn-form" id="chicasBtn">Chicas</button>
            <button class="btn-form" id="medianasBtn">Medianas</button>
            <button class="btn-form" id="grandesBtn">Grandes</button>
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Bordes en las imagenes: :</h2>
            <button class="btn-form" id="bordesDelgadosBtn">Si</button>
            <button class="btn-form" id="eliminarBordesBtn">No</button>
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Tamaño de los bordes: :</h2>
            <button class="btn-form" id="pequenosBtn">Chico</button>
            <button class="btn-form" id="medianosBtn">Mediano</button>
            <button class="btn-form" id="grandesBtn">Grande</button>
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Color de los Bordes:</h2>
            <input type="color" id="colorBordeInput" onchange="establecerColorBorde" />
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Redondeo de Esquinas: :</h2>
            <button class="btn-form" id="redondearEsquinasChicoBtn">Chico</button>
            <button class="btn-form" id="redondearEsquinasMedianoBtn">Mediano</button>
            <button class="btn-form" id="redondearEsquinasGrandeBtn">Grande</button>
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Sombra en las imagenes: :</h2>
            <button class="btn-form" id="sombraBtn">Si</button>
            <button class="btn-form" id="eliminarSombraBtn">No</button>
          </section>
        </div>
      </div>
    </div>

    <div class="enlaces-configuracion">
      <h3><span class="punto">&#8226;</span> Tablas <button id="boton-tablas" class="flecha" onclick="toggleOpciones('opciones-tablas')">▼</button></h3>
      <div class="opciones-configuracion hidden" id="opciones-tablas">
        <!-- Aquí van las diferentes opciones -->
        <div class="fondo">
          <section>
            <h2>Color de los Bordes de la tabla:</h2>
            <input type="color" id="colorBordeTablaInput" />
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Color de fondo:</h2>
            <input type="color" id="colorFondoTablaInput" />
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Color de celdas de los Titulos:</h2>
            <input type="color" id="colorCeldasTituloInput" />
          </section>
        </div>
      </div>
    </div>

    <div class="enlaces-configuracion">
      <h3><span class="punto">&#8226;</span> Texto <button id="boton-texto" class="flecha" onclick="toggleOpciones('opciones-texto')">▼</button></h3>
      <div class="opciones-configuracion hidden" id="opciones-texto">
        <!-- Aquí van las diferentes opciones -->
        <div class="fondo">
          <section>
            <h2>Color de Fuente:</h2>
            <input type="color" id="colorFuenteInput" />
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Tamaño de la fuente: :</h2>
            <button class="btn-form" id="tamanioChicoBtn">Chica</button>
            <button class="btn-form" id="tamanioMedianoBtn">Mediana</button>
            <button class="btn-form" id="tamanioGrandeBtn">Grande</button>
          </section>
        </div>
        <div class="fondo">
          <section>
            <h2>Color de fondo:</h2>
            <input type="color" id="colorFondoTextoInput" onchange="establecerColorFondoTexto()" />
          </section>
        </div>
      </div>
    </div>



    <div class="form-botones">
      <button class="btn-form reset" type="reset">
        Guardar Configuracion
      </button>
      <button class="btn-form enviar" onclick="restablecerConfiguracion()">Reiniciar Configuracion</button>
    </div>

    <script src="../js/configuracion.js"></script>
    <script src="../js/productos.js"></script>
</body>


</html>