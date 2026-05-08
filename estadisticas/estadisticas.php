<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="menu-container">
    <a id="cerrar_sesion" href="../logout.php" class="btn btn-logout menu-btn">
        <i class="fas fa-sign-out-alt btn-icon"></i>
        Cerrar Sesión
    </a>
</div>
<div class= "menu-container">
    <a id="inicio" href="../menu.php" class="btn btn-home menu-btn">
        <i class="fas fa-home btn-icon"></i>
        Inicio
    </a>
</div>

<div class="menu-card">
    <h1 class="menu-title">
        <center>
            <img src="../img/unap_positivo.png" alt="Logo" class="logo" style="width: 120px; height: auto;"><br>
            Estadísticas
        </center>
    </h1>

    <div style="position: absolute; top: -50px; left: -200px;">
        <h2 style="color: white;"><?= $_SESSION['usuario'] ?></h2>
    </div>

<a href="estadistica_usuarios.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
    <i class="fas fa-chart-bar btn-icon"></i>
    Estadísticas de Usuarios
</a>

<a href="estadistica_causas.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
    <i class="fas fa-chart-bar btn-icon"></i>
    Estadísticas de Causas
</a>

<a href="estadistica_atenciones.php" class="btn btn-pacientes menu-btn" style="font-family: 'Poppins', sans-serif; font-size: 20px;">
    <i class="fas fa-chart-bar btn-icon"></i>
    Estadísticas de Atenciones
</a>
</div>

</body>
</html>
