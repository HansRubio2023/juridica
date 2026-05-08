<?php
session_start();
include("conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$query = mysqli_query($con, "SELECT id, email, fecha_logueo, usuario, rol FROM perfiles");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles</title>
    <link rel="stylesheet" href="css/panel_usuario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<a id="inicio" href="menu.php">
    <i class="fas fa-home btn-icon"></i> Inicio
</a>
<a id="cerrar_sesion" href="logout.php">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<h1>Perfiles</h1>

<div class="card-body">

    <div class="row align-items-center mb-4">
        <div class="col-md-12 text-end">
            <a href="nuevo_perfil.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Perfil
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Fecha de registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= $fila['email'] ?></td>
                    <td><?= $fila['usuario'] ?></td>
                    <td><?= $fila['rol'] ?></td>
                    <td><?= $fila['fecha_logueo'] ?></td>
                    <td class="acciones">
                        <a href="edit_perfil.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
