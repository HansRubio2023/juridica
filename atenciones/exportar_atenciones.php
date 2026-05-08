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
header('Content-Disposition: attachment; filename=atenciones.xls');

$sql = "SELECT
            CONCAT(u.rut, '-', u.dv) AS rut,
            CONCAT(u.nombres, ' ', u.apellidos) AS usuario,
            c.rit,
            tc.nombre_tipo_causa,
            a.fecha_atencion,
            (SELECT COUNT(*) FROM atenciones a2 WHERE a2.id_causa = a.id_causa AND a2.id_atencion <= a.id_atencion) AS numero_sesion,
            a.comentarios
        FROM atenciones a
        LEFT JOIN usuarios u ON a.id_usuario = u.id_usuario
        LEFT JOIN causas c ON a.id_causa = c.id_causa
        LEFT JOIN tipo_causa tc ON c.id_tipo_causa = tc.id_tipo_causa
        ORDER BY a.id_atencion DESC";

$result = mysqli_query($con, $sql);

echo "\xEF\xBB\xBF";
?>
<table>
    <tr>
        <th>RUT</th>
        <th>Usuario</th>
        <th>RIT/ROL</th>
        <th>Tipo Causa</th>
        <th>Fecha</th>
        <th>N° Sesión</th>
        <th>Comentarios</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['rut'] ?></td>
        <td><?= $row['usuario'] ?></td>
        <td><?= $row['rit'] ?></td>
        <td><?= $row['nombre_tipo_causa'] ?></td>
        <td><?= $row['fecha_atencion'] ?></td>
        <td><?= $row['numero_sesion'] ?></td>
        <td><?= $row['comentarios'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
