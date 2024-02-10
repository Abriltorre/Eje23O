<?php
// Mostrar las últimas publicaciones de la base de datos con información del usuario
include "config.php";

$query = "SELECT publicaciones.contenido, publicaciones.imagen, publicaciones.fecha, usuarios.usuario 
          FROM publicaciones 
          INNER JOIN usuarios ON publicaciones.ID_Usuario = usuarios.ID_Usuario
          ORDER BY publicaciones.fecha DESC 
          LIMIT 5";

$resultado = mysqli_query($conn, $query);

// Inicializar la variable $publicaciones como un array vacío
$publicaciones = array();

while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<div>";
    echo "<p><strong>Usuario:</strong> " . $fila['usuario'] . "</p>";
    echo "<p><strong>Contenido:</strong> " . $fila['contenido'] . "</p>";
    
    // Mostrar la imagen si existe
    if (!empty($fila['imagen'])) {
        echo "<img src='" . $fila['imagen'] . "' alt='Imagen de la publicación'>";
    } else {
        echo "<p>Esta publicación no tiene imagen.</p>";
    }
    
    echo "<p><strong>Fecha:</strong> " . $fila['fecha'] . "</p>";
    echo "</div>";
}

mysqli_close($conn);