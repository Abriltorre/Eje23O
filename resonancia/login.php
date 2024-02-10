<?php
session_cache_limiter('private');
session_start();
include 'head.php';
include 'verificar_credenciales.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $id_usuario = verificarCredenciales($usuario, $contrasena);

    if ($id_usuario != null) {
        // Establecer la sesión si no está iniciada
        if (!isset($_SESSION)) {
            session_start();
        }
        // Guardar el ID del usuario en la sesión
        $_SESSION['ID_Usuario'] = $id_usuario;

        // Redirigir a la página principal
        header("Location: principal.php");
        exit();
    } else {
        echo '<div class="alert alert-danger mt-2 mb-5" role="alert">' . $_SESSION['loginError'] . '</div>';
        unset($_SESSION['loginError']);
    }

    if (isset($_SESSION['loginError'])) {
        echo '<div class="alert alert-danger mt-2 mb-5" role="alert">' . $_SESSION['loginError'] . '</div>';
        unset($_SESSION['loginError']);
    }
}
?>

<head>
    <title>Ingresar</title>
</head>
<div class="center-container">

    <!-- Contenedor del formulario de login y la imagen -->
    <div class="flex-container mt-5">

        <!-- Contenedor del formulario de login -->
        <div class="content-action form-container">
            <h4>Iniciar sesión</h4>
            <form action="login.php" method='POST'>
                <div class="form-group">
                    <input type="text" class="form-control rounded" name="usuario" placeholder="Usuario" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control rounded" name="contrasena" placeholder="Contraseña"
                        required>
                </div>
                <button type="submit" class="btn btn-primary btn-block rounded">Ingresar</button>
            </form>
            <?php if (isset($_SESSION['loginComplete'])): ?>
                <div class="alert alert-warning alert-dismissible fade show mt-2 mb-5" role="alert">
                    <?php echo $_SESSION['loginComplete'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['loginComplete']); endif ?>
            <div class="content-link mt-2">
                <span class="mr-2">¿Aún no tienes una cuenta en Resso?</span><a href="registro.php">Registrarme</a>
            </div>
        </div>

        <!-- Contenedor de la imagen -->
        <div class="content-image">
            <img src="resso.jpg" alt="Orquesta" class="img-fluid rounded">
        </div>
    </div>
</div>