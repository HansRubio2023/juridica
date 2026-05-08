<?php
session_start();
include("conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/formulario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<a id="inicio" href="menu.php" class="btn">
    <i class="fas fa-home btn-icon"></i> Inicio
</a>
<a id="cerrar_sesion" href="logout.php" class="btn">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<div class="form-card" style="max-width: 450px;">

    <h2 class="text-center">
        <i class="fas fa-user-cog"></i> Nuevo Perfil
    </h2>

      <div class="text-center fw-bold mb-3">
        
    <p class="text"><small> Se deben llenar todos los campos obligatorios *</small></p>
    </div>


    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_GET['error'] == 'email_exists' ? 'El email ya está registrado.' : 'Error al insertar el perfil.' ?>
        </div>
    <?php endif; ?>

    <form action="insert_perfil.php" method="POST">

        <div class="mb-3">
            <label><i class="fa-solid fa-envelope text-primary me-1"></i> Email *</label>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>

        <div class="mb-3">
            <label><i class="fa-solid fa-key text-primary me-1"></i> Contraseña *</label>
            <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
        </div>

        <div class="mb-3">
            <label><i class="fas fa-user text-primary me-1"></i> Nombre *</label>
            <input type="text" class="form-control" name="usuario" placeholder="Nombre" required>
        </div>

        <div class="mb-3">
            <label><i class="fas fa-id-badge text-primary me-1"></i> Rol *</label>
            <select class="form-select" name="rol" required>
                <option value="admin">Admin</option>
                <option value="usuario">Usuario</option>
                <option value="estudiante">Estudiante</option>
            </select>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="perfiles.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>

</body>
</html>
