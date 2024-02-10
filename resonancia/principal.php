<?php session_start(); ?>
<? ini_set('display_errors', 1);?>

<!DOCTYPE html>

<html lang="es">

<head>
    <? $publicaciones = array(); ?>
    <?php include 'head.php'; ?>
    <? include "mostrar_publicaciones.php"; ?>

    <title>Resonancia</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="icon" href="resso.jpg" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header>
        <div class="center">
            <h1>¡Bienvenido a Resso!</h1>
        </div>
        <div class="center">
            <a href="http://localhost/resonancia/" target="_blank">
                <img src="resso.jpg" alt="imagen.jpg" width="150" height="150" />
            </a>
        </div>
        <?php if (isset($_SESSION['ID_Usuario'])): ?> <!-- Modificar aquí -->
            <div class="center">
                <form action="cerrar_sesion.php" method="post"> <!-- Corregir el atributo action -->
                    <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                </form>
            </div>
        <?php endif; ?>
    </header>

    <section>
        <p>Sección de prueba</p>
    </section>

    <div style="width: 50%; margin: 0 auto">
        <div class="center">
            <h3>Genera tus propias resonancias con estilo</h3>
        </div>
        <br />
        <label>Carga aquí tu foto (opcional)</label>
        <input type="file" id="imageLoader" name="imageLoader" />
        <p>
            Te compartimos el siguiente
            <a href="https://www.online-image-editor.com/">editor</a> de imágenes.
            ¡Seguro que te ayudará!
        </p>
        <div class="center">
            <canvas id="imageCanvas"></canvas>
        </div>
        <label>Carga tu link para poder transformarlo en un QR-Resso</label>
        <input class="w3-input" id="text" type="text" />
        <br />
        <div class="tooltip">
            Tamaño de bit
            <span class="tooltiptext">Eres libre de decidir el tamaño de tu imágen en Resso.</span>
            <span id="printSize"></span>
        </div>

        <br /><br />

        <div class="slidecontainer">
            <input type="range" min="10" max="100" value="30" class="slider" id="radiusSize" />
        </div>

        <br />

        <div class="tooltip">
            Tamaño Resso:
            <span class="tooltiptext">Elige el tamaño de tu QR-Resso como tú prefieras.</span>
            <span id="printCorrection"></span>
        </div>

        <br /><br />

        <div class="slidecontainer">
            <input type="range" min="1" max="3" value="3" class="slider" id="errorCorrection" />
        </div>

        <br />

        <div class="tooltip">
            Tamaño del borde:
            <span class="tooltiptext">Dependiendo de tu gusto elige el tamaño del borde blanco alrededor del código
                QR.</span>
            <span id="printBorderSize"></span>
        </div>

        <br /><br />

        <div class="slidecontainer">
            <input type="range" min="0" max="5" value="0" class="slider" id="borderSize" />
        </div>

        <br />

        <input type="checkbox" id="whitebackground" name="whitebackground" />
        <label for="whitebackground">Fondo blanco</label><br />

        <br />

        <div class="center">
            <button class="w3-button w3-white w3-border w3-border-blue" style="margin: 0 auto" onclick="makeCode()">
                Generar QR-RessoCode
            </button>
        </div>

        <br />

        <div class="center">
            <canvas id="myCanvas"></canvas>
        </div>

        <br />

        <div class="center">
            <button class="w3-button w3-white w3-border w3-border-blue" style="margin: 0 auto" onclick="download()">
                Descarga tu QR-Resso
            </button>
        </div>
        <br />
        <div class="center">
            <span class="tooltiptext">Te invitamos a compartir con nosotros tu forma de expresión a través de
                Resso.</span>
            <br />
            <br />
            <br />
        </div>
    </div>

    <br />

    <br />

    <h3>Publicaciones</h3>

    <form action="procesar_publicacion.php" method="post" enctype="multipart/form-data">
        <!-- Agregar campo oculto para el ID de usuario -->
        <?php if (isset($_SESSION['ID_Usuario'])): ?>
            <input type="hidden" name="ID_Usuario" value="<?php echo $_SESSION['ID_Usuario']; ?>">
        <?php endif; ?>
        <label for="contenido">Contenido:</label>
        <textarea name="contenido" required></textarea>
        <br />
        <br />
        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen">
        <br />
        <br />
        <button type="submit">Publicar</button>
    </form>

    <h3>Publicaciones</h3>

    <? if (!empty($publicaciones)) {
        foreach ($publicaciones as $publicacion) {
            echo "<div class='publicacion'>";
            echo "<p>" . $publicacion['contenido'] . "</p>";
            if ($publicacion['imagen']) {
                echo "<img src='uploads/" . $publicacion['imagen'] . "' alt='imagen' width='200'><br>";
            }
            echo "<p>Fecha de publicación: " . $publicacion['fecha'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay publicaciones disponibles.</p>";
    }

    ?>

    <h5>Últimas Publicaciones</h5>

    <div class="center">
        <p>
            *Ten en cuenta que es posible que estos códigos QR no funcionen con todos los códigos QR lector,te
            recomiendo que te asegures de probarlos primero. Si estas teniendo problemas, es posible que debas
            aumentar el tamaño de bits.
        </p>
    </div>

    <a id="link"></a>
    <div id="qrcode" style="display: none"></div>
    <script src="qrcode.js"></script>
    <script src="index.js"></script>

    <footer>
        <p>&copy;
            <?php echo date("Y"); ?> Resso
        </p>
        <div>
            <a href="http://localhost/resonancia/" target="_blank"><i class="fa fa-github"
                    style="font-size: 36px"></i></a>
        </div>
    </footer>
</body>

</html>