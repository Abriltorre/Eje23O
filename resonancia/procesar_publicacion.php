<?php
include "config.php";

// Ruta de la carpeta de uploads
$rutaUploads = "uploads/";

// Nombre de la imagen por defecto
$imagenDefault = "default.jpg";

// Verificar si la carpeta de uploads existe, si no, crearla
if (!file_exists($rutaUploads)) {
    if (!mkdir($rutaUploads, 0777, true)) {
        die("Error al crear la carpeta de uploads");
    }
}

// Verificar si la imagen por defecto no existe, si no, crearla
if (!file_exists($rutaUploads . $imagenDefault)) {
    // Crear una imagen por defecto, puedes usar imagecreate() para crear una imagen en blanco
    $imagenPorDefecto = imagecreate(200, 200); // Ancho y alto de la imagen
    imagecolorallocate($imagenPorDefecto, 255, 255, 255); // Establecer el color de fondo blanco

    // Guardar la imagen por defecto en la carpeta de uploads
    imagejpeg($imagenPorDefecto, $rutaUploads . $imagenDefault);
    imagedestroy($imagenPorDefecto);
}

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si se han enviado todos los datos necesarios
if (isset($_POST['contenido']) && isset($_SESSION['ID_Usuario'])) {
    // Obtener los datos del formulario
    $contenido = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['contenido']));
    $ID_Usuario = $_SESSION['ID_Usuario'];

    // Verificar si se ha subido una imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Obtener la información de la imagen
        $imagen = $_FILES['imagen'];
        $nombreImagen = $imagen['name'];
        $imagenTmp = $imagen['tmp_name'];

        // Obtener la extensión del archivo
        $extension = pathinfo($nombreImagen, PATHINFO_EXTENSION);

        // Validar la extensión del archivo
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            echo "Tipo de archivo no válido. Se requiere una imagen JPEG, PNG o GIF.";
            exit();
        }

        // Guardar la imagen en la carpeta de uploads
        $rutaImagen = "uploads/" . uniqid('imagen_') . ".$extension";
        if (!move_uploaded_file($imagenTmp, $rutaImagen)) {
            echo "Error al subir la imagen.";
            exit();
        }
    } else {
        // Si no se subió una imagen, asignar una imagen por defecto
        $rutaImagen = "uploads/default.jpg";
    }

    // Insertar la publicación en la base de datos
    $fecha = date("Y-m-d H:i:s"); // Obtener la fecha actual
    $sql = "INSERT INTO publicaciones (ID_Usuario, contenido, imagen, fecha) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isss', $ID_Usuario, $contenido, $rutaImagen, $fecha);
    if (mysqli_stmt_execute($stmt)) {
        echo "Publicación realizada correctamente";
    } else {
        echo "Error al publicar la entrada: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Todos los campos son obligatorios.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);