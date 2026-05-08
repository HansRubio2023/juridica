<?php
session_start();
include("conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'];
    $email      = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $usuario    = $_POST['usuario'];
    $rol        = $_POST['rol'];

    $verificar = "SELECT * FROM perfiles WHERE email = '$email' AND id != '$id'";
    if (mysqli_num_rows(mysqli_query($con, $verificar)) > 0) {
        header("Location: edit_perfil.php?id=$id&error=email_exists");
        exit;
    }

    if (!empty($contrasena)) {
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE perfiles SET email='$email', contrasena='$contrasena', usuario='$usuario', rol='$rol' WHERE id='$id'";
    } else {
        $sql = "UPDATE perfiles SET email='$email', usuario='$usuario', rol='$rol' WHERE id='$id'";
    }

    if (mysqli_query($con, $sql)) {
        header("Location: perfiles.php");
        exit;
    } else {
        header("Location: edit_perfil.php?id=$id&error=update_failed");
        exit;
    }
}

$id    = $_GET['id'] ?? '';
if (empty($id)) { header("Location: perfiles.php"); exit; }

$fila = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM perfiles WHERE id = '$id'"));
if (!$fila) { header("Location: perfiles.php"); exit; }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
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
        <i class="fas fa-user-cog"></i> Editar Perfil
    </h2>

   <div class="text-center fw-bold mb-3">
        
    <p class="text"><small> Se deben llenar todos los campos obligatorios *</small></p>
    </div>


    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_GET['error'] == 'email_exists' ? 'El email ya está registrado por otro perfil.' : 'Error al actualizar el perfil.' ?>
        </div>
    <?php endif; ?>

    <form action="edit_perfil.php" method="POST">
        <input type="hidden" name="id" value="<?= $fila['id'] ?>">

        <div class="mb-3">
            <label><i class="fa-solid fa-envelope text-primary me-1"></i> Email *</label>
            <input type="email" class="form-control" name="email" value="<?= $fila['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label><i class="fa-solid fa-key text-primary me-1"></i> Contraseña</label>
            <input type="password" class="form-control" name="contrasena" placeholder="Dejar vacío para no cambiar">
        </div>

        <div class="mb-3">
            <label><i class="fas fa-user text-primary me-1"></i> Nombre *</label>
            <input type="text" class="form-control" name="usuario" value="<?= $fila['usuario'] ?>" required>
        </div>

        <div class="mb-3">
            <label><i class="fas fa-id-badge text-primary me-1"></i> Rol *</label>
            <select class="form-select" name="rol" required>
                <option value="admin"      <?= $fila['rol'] == 'admin'      ? 'selected' : '' ?>>Admin</option>
                <option value="usuario"    <?= $fila['rol'] == 'usuario'    ? 'selected' : '' ?>>Usuario</option>
                <option value="estudiante" <?= $fila['rol'] == 'estudiante' ? 'selected' : '' ?>>Estudiante</option>
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
