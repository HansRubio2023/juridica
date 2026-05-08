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
header('Content-Disposition: attachment; filename=usuarios.xls');

$sql = "SELECT
            u.rut,
            u.dv,
            u.nombres,
            u.apellidos,
            u.email,
            u.celular,
            u.telefono_fijo,
            ec.nombre_estado_civil,
            u.domicilio,
            c.nombre_comuna,
            u.sector,
            u.fecha_ingreso
        FROM usuarios u
        LEFT JOIN estado_civil ec ON u.id_estado_civil = ec.id_estado_civil
        LEFT JOIN comunas c ON u.id_comuna = c.id_comuna
        ORDER BY u.id_usuario DESC";

$result = mysqli_query($con, $sql);

echo "\xEF\xBB\xBF";
?>
<table>
    <tr>
        <th>RUT</th>
        <th>DV</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Celular</th>
        <th>Estado Civil</th>
        <th>Domicilio</th>
        <th>Comuna</th>
        <th>Sector</th>
        <th>Teléfono Fijo</th>
        <th>Fecha Ingreso</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['rut'] ?></td>
        <td><?= $row['dv'] ?></td>
        <td><?= $row['nombres'] ?></td>
        <td><?= $row['apellidos'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['celular'] ?></td>
        <td><?= $row['nombre_estado_civil'] ?></td>
        <td><?= $row['domicilio'] ?></td>
        <td><?= $row['nombre_comuna'] ?></td>
        <td><?= $row['sector'] ?></td>
        <td><?= $row['telefono_fijo'] ?></td>
        <td><?= $row['fecha_ingreso'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
