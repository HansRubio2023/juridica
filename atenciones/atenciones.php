<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$sql = "SELECT
            a.id_atencion,
            a.id_usuario,
            CONCAT(u.rut, '-', u.dv) AS rut_completo,
            CONCAT(u.nombres, ' ', u.apellidos) AS usuario,
            c.rit,
            tc.nombre_tipo_causa,
            a.responsable,
            a.fecha_atencion,
            a.comentarios,
            (SELECT COUNT(*) FROM atenciones a2 WHERE a2.id_causa = a.id_causa) AS atenciones_causa,
            (SELECT COUNT(*) FROM atenciones a2 WHERE a2.id_causa = a.id_causa AND a2.id_atencion <= a.id_atencion) AS numero_sesion
        FROM atenciones a
        LEFT JOIN usuarios u ON a.id_usuario = u.id_usuario
        LEFT JOIN causas c ON a.id_causa = c.id_causa
        LEFT JOIN tipo_causa tc ON c.id_tipo_causa = tc.id_tipo_causa
        ORDER BY a.id_atencion DESC";

$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atenciones</title>
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

<h1>Atenciones</h1>

<div style="position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999;">
       
    <a href="exportar_atenciones.php" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Descargar Excel
    </a>
</div>

<div class="card-body">

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-primary"></i>
                </span>
                <input type="text"
                    class="form-control border-start-0 shadow-none"
                    id="buscador"
                    placeholder="Buscar por RUT, nombre, RIT..."
                    autocomplete="off">
                <button class="btn btn-outline-danger" type="button"
                    id="btn-limpiar" style="display:none;">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="nueva_atencion.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Nueva Atención
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>RUT</th>
                    <th>Usuario</th>
                    <th>RIT/ROL</th>
                    <th>Tipo Causa</th>
                    <th>Responsable</th>
                    <th>Fecha</th>
                    <th>Atenciones por causa</th>
                    <th>N° Sesión</th>
                    <th>Comentarios</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <tr class="atencion-row">
                <td><a href="../ver_causas.php?id_usuario=<?= $row['id_usuario'] ?>">
                <?= $row['rut_completo'] ?> 
                </a>
                </td>
                    <td><?= $row['usuario'] ?></td>
                    <td><?= $row['rit'] ?></td>
                    <td><?= $row['nombre_tipo_causa'] ?></td>
                    <td><?= $row['responsable'] ?></td>
                    <td><?= $row['fecha_atencion'] ?></td>
                    <td><?= $row['atenciones_causa'] ?></td>
                    <td><?= $row['numero_sesion'] ?></td>
                    <td><?= $row['comentarios'] ?></td>
                    <td class="acciones">
                        <a href="editar_atencion.php?id_atencion=<?= $row['id_atencion'] ?>"
                           class="btn btn-warning btn-sm">
                           <i class="fas fa-edit"></i>
                        </a>
                        <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <a href="eliminar_atencion.php?id_atencion=<?= $row['id_atencion'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar esta atención?');">
                           <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscador   = document.getElementById('buscador');
    const btnLimpiar = document.getElementById('btn-limpiar');

    function buscar() {
        const termino = buscador.value.trim().toLowerCase();
        document.querySelectorAll('.atencion-row').forEach(fila => {
            fila.style.display = fila.innerText.toLowerCase().includes(termino) ? '' : 'none';
        });
        btnLimpiar.style.display = termino ? 'block' : 'none';
    }

    buscador.addEventListener('input', buscar);

    btnLimpiar.addEventListener('click', function() {
        buscador.value = '';
        buscar();
        buscador.focus();
    });
});


</script>

</body>
</html>