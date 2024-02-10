<?php
session_start();
include 'head.php'; // Incluir el encabezado si es necesario

// Verificar si la sesión está establecida después de registrar con éxito
if (isset($_SESSION['ID_Usuario'])) {
    // Asignar aquí el ID del usuario que acabas de registrar
    $nuevo_id_usuario = $_SESSION['ID_Usuario'];

    // Redireccionar al usuario a la página principal
    header("Location: principal.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Registrarse</title>
</head>

<body>
    <div class="center-container">
        <div class="flex-container mt-5">
            <div class="content-action form-container">
                <h4>Registrarme</h4>
                <form action="procesar_registro.php" method='POST'>
                    <div class="form-group">
                        <input type="text" class="form-control rounded" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control rounded" name="usuario" placeholder="Usuario" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control rounded" name="email" placeholder="Email" required>
                    </div>
                    <div>
                        <input type="password" class="form-control rounded" name="password" placeholder="Contraseña"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block rounded">Registrarme</button>
                </form>
                <?php if (isset($_SESSION['usuarioError'])): ?>
                    <div class="alert alert-warning alert-dismissible fade show mt-2 mb-5" role="alert">
                        <?php echo $_SESSION['usuarioError'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['usuarioError']); endif ?>
                <div class="content-link mt-2">
                    <span class="mr-2">¿Ya tienes una cuenta?</span><a href="login.php">Ingresar</a>
                </div>
            </div>
            <div class="content-image">
                <img src="login.jpg" alt="Orquesta" class="img-fluid rounded">
            </div>
        </div>
    </div>
</body>

</html>