<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$sql = "SELECT u.*, 
        ec.nombre_estado_civil AS nombre_estado, 
        c.nombre_comuna AS nombre_comuna
        FROM usuarios u
        LEFT JOIN estado_civil ec ON u.id_estado_civil = ec.id_estado_civil
        LEFT JOIN comunas c ON u.id_comuna = c.id_comuna
        ORDER BY u.id_usuario DESC";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/panel_usuario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<a id="inicio" href="../menu.php">
    <i class="fas fa-home btn-icon"></i> Inicio
</a>
<a id="cerrar_sesion" href="../logout.php">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<h1>Usuarios</h1>

<div style="position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999;">
    <a href="exportar_usuarios.php" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Descargar Excel
    </a>
</div>

<div class="card-body">

    <?php if (isset($_SESSION['error_usuario'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_SESSION['error_usuario'] ?>
        </div>
        <?php unset($_SESSION['error_usuario']); ?>
    <?php endif; ?>

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-primary"></i>
                </span>
                <input type="text"
                    class="form-control border-start-0 shadow-none"
                    id="buscador"
                    placeholder="Buscar por: RUT, Nombre, Apellido, Email"
                    autocomplete="off">
                <button class="btn btn-outline-danger" type="button"
                    id="btn-limpiar" style="display:none;">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="nuevo_usuario.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>RUT</th>
                    <th>DV</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Estado Civil</th>
                    <th>Domicilio</th>
                    <th>Comuna</th>
                    <th>Sector</th>
                    <th>Teléfono Fijo</th>
                    <th>Fecha Ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($result)): ?>
                <tr class="usuario-row">
                    <td><?= number_format($row['rut'], 0, '', '.') ?></td>
                    <td><?= $row['dv'] ?></td>
                    <td><?= $row['nombres'] ?></td>
                    <td><?= $row['apellidos'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['celular'] ?></td>
                    <td><?= $row['nombre_estado'] ?></td>
                    <td><?= $row['domicilio'] ?></td>
                    <td><?= $row['nombre_comuna'] ?></td>
                    <td><?= $row['sector'] ?></td>
                    <td><?= $row['telefono_fijo'] ?></td>
                    <td><?= $row['fecha_ingreso'] ?></td>
                    <td class="acciones">
                        <a href="editar_usuario.php?id_usuario=<?= $row['id_usuario'] ?>"
                            class="btn btn-warning btn-sm me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="eliminar_usuario.php?id_usuario=<?= $row['id_usuario'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Eliminar usuario?');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
const buscador   = document.getElementById('buscador');
const btnLimpiar = document.getElementById('btn-limpiar');
const filas      = document.querySelectorAll('.usuario-row');

buscador.addEventListener('input', function() {
    const texto = this.value.toLowerCase();
    btnLimpiar.style.display = texto ? 'block' : 'none';
    filas.forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(texto) ? '' : 'none';
    });
});

btnLimpiar.addEventListener('click', function() {
    buscador.value = '';
    this.style.display = 'none';
    filas.forEach(fila => fila.style.display = '');
});
</script>

</body>
</html>