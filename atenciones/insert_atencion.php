<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$id_usuario     = $_POST['id_usuario'] ?? '';
$id_causa       = $_POST['id_causa'] ?? '';
$id_responsable = $_POST['id_responsable'] ?? '';
$fecha_atencion = $_POST['fecha_atencion'] ?? '';
$comentarios    = $_POST['comentarios'] ?? '';

if (empty($id_usuario) || empty($id_causa) || empty($id_responsable) || empty($fecha_atencion)) {
    die("Faltan campos obligatorios");
}

$sql = "INSERT INTO atenciones (id_usuario, id_causa, id_responsable, fecha_atencion, comentarios)
        VALUES ('$id_usuario', '$id_causa', '$id_responsable', '$fecha_atencion', '$comentarios')";

$result = mysqli_query($con, $sql);

if ($result) {
    header("Location: atenciones.php");
    exit;
} else {
    echo "Error al insertar: " . mysqli_error($con);
}
?>