<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$sql = "SELECT 
        c.id_causa,
        CONCAT(u.rut, '-', u.dv) AS rut_completo,
        u.nombres,
        u.apellidos,
        tc.nombre_tipo_causa,
        cat.nombre_categoria,
        r.nombre_responsable,
        rc.nombre_resultado_causa,
        c.rit,
        c.observaciones,
        c.responsable
    FROM causas c
    LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
    LEFT JOIN tipo_causa tc ON c.id_tipo_causa = tc.id_tipo_causa
    LEFT JOIN categoria cat ON c.id_categoria = cat.id_categoria
    LEFT JOIN responsables r ON c.id_responsable = r.id_responsable
    LEFT JOIN resultado_causa rc ON c.id_resultado = rc.id_resultado_causa
    ORDER BY c.id_causa DESC";

$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Causas</title>
<link rel="stylesheet" href="../css/panel_usuario.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<a id="inicio" href="../menu.php">
    <i class="fas fa-home btn-icon"></i> Inicio
</a>
<a id="cerrar_sesion" href="../logout.php">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<h1>Causas</h1>

<div style="position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999;">
     <?php if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'usuario'): ?>
    <a href="exportar_causas.php" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Descargar Excel
    </a>
    <?php endif ?>
</div>

<div class="card-body">

    <?php if (isset($_SESSION['error_causa'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_SESSION['error_causa'] ?>
        </div>
        <?php unset($_SESSION['error_causa']); ?>
    <?php endif; ?>

    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-primary"></i>
                </span>
                <input type="text" id="buscador" class="form-control border-start-0 shadow-none"
                    placeholder="Buscar por RUT, nombre, RIT...">
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="nueva_causa.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Nueva Causa
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>RIT/ROL</th>
                    <th>Tipo</th>
                    <th>Competencia</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th>Visualizar <br>Archivos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($query)): ?>
                <tr class="causa-row">
                    <td><?= $row['rut_completo'] ?></td>
                    <td><?= $row['nombres'] ?></td>
                    <td><?= $row['apellidos'] ?></td>
                    <td><?= $row['rit'] ?></td>
                    <td><?= $row['nombre_tipo_causa'] ?></td>
                    <td><?= $row['nombre_categoria'] ?></td>
                     <td><?= $row['responsable'] ?></td>
                    <td><?= $row['nombre_resultado_causa'] ?></td>
                  
                   <td>
                    <a href="ver_archivos.php?id_causa=<?= $row['id_causa'] ?>"
                    class="btn btn-info btn-sm">
                    <i class="fas fa-file"></i>
                    </a>
                    </td>
                    <td class="acciones">
                       
                        <a href="editar_causa.php?id_causa=<?= $row['id_causa'] ?>"
                           class="btn btn-warning btn-sm">
                           <i class="fas fa-edit"></i>
                        </a>
                        <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <a href="eliminar_causa.php?id_causa=<?= $row['id_causa'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar esta causa?');">
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
document.getElementById('buscador').addEventListener('input', function() {
    let filtro = this.value.toLowerCase();
    document.querySelectorAll('.causa-row').forEach(fila => {
        fila.style.display = fila.innerText.toLowerCase().includes(filtro) ? '' : 'none';
    });
});
</script>

</body>
</html>