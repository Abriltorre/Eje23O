<?php
function verificarCredenciales($usuario, $contraseña)
{
    include 'config.php';
    $verificarCredenciales = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($verificarCredenciales);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contraseña, $row['contraseña'])) {
            // Devuelve el ID del usuario si las credenciales son correctas
            return $row['ID_Usuario'];
        } else {
            $_SESSION['loginError'] = 'Contraseña incorrecta';
        }
    } else {
        $_SESSION['loginError'] = 'Usuario no encontrado';
    }
    $conn->close();
    
    // Devuelve null si las credenciales no son correctas
    return null;
}