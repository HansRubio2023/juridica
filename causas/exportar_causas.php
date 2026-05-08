<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

mysqli_set_charset($con, 'utf8');
mysqli_query($con, "SET NAMES 'utf8'");

header('Content-type: application/xls; charset=UTF-8');
header('Content-Disposition: attachment; filename=causas.xls');

$sql = "SELECT
            CONCAT(u.rut, '-', u.dv) AS rut,
            u.nombres,
            u.apellidos,
            c.rit,
            tc.nombre_tipo_causa,
            cat.nombre_categoria,
            r.nombre_responsable,
            rc.nombre_resultado_causa,
            c.observaciones
        FROM causas c
        LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
        LEFT JOIN tipo_causa tc ON c.id_tipo_causa = tc.id_tipo_causa
        LEFT JOIN categoria cat ON c.id_categoria = cat.id_categoria
        LEFT JOIN responsables r ON c.id_responsable = r.id_responsable
        LEFT JOIN resultado_causa rc ON c.id_resultado = rc.id_resultado_causa
        ORDER BY c.id_causa DESC";

$result = mysqli_query($con, $sql);

echo "\xEF\xBB\xBF";
?>
<table>
    <tr>
        <th>RUT</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>RIT/ROL</th>
        <th>Tipo Causa</th>
        <th>Categoría</th>
        <th>Responsable</th>
        <th>Resultado</th>
        <th>Observaciones</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['rut'] ?></td>
        <td><?= $row['nombres'] ?></td>
        <td><?= $row['apellidos'] ?></td>
        <td><?= $row['rit'] ?></td>
        <td><?= $row['nombre_tipo_causa'] ?></td>
        <td><?= $row['nombre_categoria'] ?></td>
        <td><?= $row['nombre_responsable'] ?></td>
        <td><?= $row['nombre_resultado_causa'] ?></td>
        <td><?= $row['observaciones'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
