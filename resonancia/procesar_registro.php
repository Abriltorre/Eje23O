<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $verificarUsuario = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($verificarUsuario);

    if ($result->num_rows > 0)
        echo 'Usuario existente, intenta con otro';
    else {
        $insertarUsuario = "INSERT INTO usuarios (nombre, usuario, email, contraseña, privilegios) VALUES ('$nombre', '$usuario', '$email', '$contraseña', 'U')";
        if ($conn->query($insertarUsuario) === true) {
            header('Location: login.php');
            exit();
        } else
            echo 'Error al insertar usuario: ' . $conn->error;
    }
}

$conn->close();