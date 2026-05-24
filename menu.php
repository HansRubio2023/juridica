<?php
session_start();
include("conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="css/menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="menu-container">
    <a id="cerrar_sesion" href="logout.php" class="btn btn-logout menu-btn">
        <i class="fas fa-sign-out-alt btn-icon"></i>
        Cerrar Sesión
    </a>
</div>

<div class="menu-card">
    <h1 class="menu-title">
        <center>
            <img src="img/unap_positivo.png" alt="Logo" class="logo" style="width: 120px; height: auto;"><br>
            App Clínica Jurídica
        </center>
    </h1>

    <div style="position: absolute; top: -50px; left: -200px;">
        <h2 style="color: white;"><?= $_SESSION['usuario'] ?></h2>
    </div>

    <!-- Usuarios -->
    <?php if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'usuario'): ?>
        <a href="usuarios/usuarios.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
            <i class="fas fa-users btn-icon"></i>
            Usuarios
        </a>
    <?php endif; ?>

      <!-- Atenciones -->
    <?php if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'usuario'): ?>
        <a href="atenciones/atenciones.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
            <i class="fas fa-file-medical btn-icon"></i>
            Atenciones
        </a>
        <?php endif; ?>

    <!-- Causas -->
    <a href="causas/causas.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
        <i class="fas fa-gavel btn-icon"></i>
        Causas
    </a>

    <!-- Estadísticas -->
     <!--
     <?php //if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'usuario'): ?>
        <a href="estadisticas/estadisticas.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
            <i class="fas fa-chart-bar btn-icon"></i>
            Estadísticas
        </a>
    <?php //endif; ?>
    -->
    <!-- Perfiles solo admin -->
    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="perfiles.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
            <i class="fas fa-user-cog btn-icon"></i>
            Perfiles
        </a>
    <?php endif; ?>

</div>

</body>
</html>
