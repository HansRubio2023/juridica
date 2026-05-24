<?php
session_start();
include("conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$id_usuario = $_GET['id_usuario'] ?? '';
if (empty($id_usuario)) { header("Location: menu.php"); exit; }

$usuario = mysqli_fetch_assoc(mysqli_query($con,
    "SELECT CONCAT(rut, '-', dv) AS rut_completo, nombres, apellidos
     FROM usuarios WHERE id_usuario = '$id_usuario'"));

$sql = "SELECT c.rit, tc.nombre_tipo_causa, rc.nombre_resultado_causa,
               c.observaciones, d.nombre_archivo, d.ruta, d.fecha_subida
        FROM causas c
        LEFT JOIN tipo_causa tc ON c.id_tipo_causa = tc.id_tipo_causa
        LEFT JOIN resultado_causa rc ON c.id_resultado = rc.id_resultado_causa
        LEFT JOIN documentos_causa d ON c.id_causa = d.id_causa
        WHERE c.id_usuario = '$id_usuario'
        ORDER BY c.id_causa DESC";

$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Causas Asociadas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/panel_usuario.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<a id="inicio" href="atenciones/atenciones.php">
    <i class="fas fa-arrow-left btn-icon"></i> Volver
</a>
<a id="cerrar_sesion" href="logout.php">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<h1>Causas Asociadas</h1>

<div class="card-body">

    <div class="mb-4">
        <p><strong>RUT:</strong> <?= $usuario['rut_completo'] ?></p>
        <p><strong>Nombre:</strong> <?= $usuario['nombres'] ?> <?= $usuario['apellidos'] ?></p>
    </div>

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-primary"></i>
                </span>
                <input type="text"
                    class="form-control border-start-0 shadow-none"
                    id="buscador"
                    placeholder="Buscar por RIT, tipo, resultado..."
                    autocomplete="off">
                <button class="btn btn-outline-danger" type="button"
                    id="btn-limpiar" style="display:none;">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>RIT/ROL</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Seguimiento</th>
                    <th>Visualizar</th>
                    <th>Fecha subida</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <tr class="causa-row">
                    <td><?= $row['rit'] ?></td>
                    <td><?= $row['nombre_tipo_causa'] ?></td>
                    <td><?= $row['nombre_resultado_causa'] ?></td>
                    <td><?= $row['observaciones'] ?></td>
                    <td>
                        <?php if (!empty($row['nombre_archivo'])): ?>
                            <a href="uploads/<?= $row['nombre_archivo'] ?>" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> <?= $row['nombre_archivo'] ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Sin archivos</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $row['fecha_subida'] ?? '-' ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


</div>

<script>
const buscador   = document.getElementById('buscador');
const btnLimpiar = document.getElementById('btn-limpiar');
const filas      = document.querySelectorAll('.causa-row');

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
