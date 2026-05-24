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
$responsable = $_SESSION['usuario'];

if (empty($id_usuario)  || empty($fecha_atencion)) {
    die("Faltan campos obligatorios");
}

$id_causa_val = !empty($id_causa) ? "'$id_causa'" : "NULL";
$sql = "INSERT INTO atenciones (id_usuario, id_causa, id_responsable, responsable, fecha_atencion, comentarios)
        VALUES ('$id_usuario', $id_causa_val, NULL, '$responsable', '$fecha_atencion', '$comentarios')";

        

$result = mysqli_query($con, $sql);

if ($result) {
    header("Location: atenciones.php");
    exit;
} else {
    echo "Error al insertar: " . mysqli_error($con);
}
?>