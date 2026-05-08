<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$id_causa = $_POST['id_causa'] ?? '';
if (empty($id_causa)) { header("Location: causas.php"); exit; }

if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
    $nombre  = time() . '_' . basename($_FILES['archivo']['name']);
    $destino = "../uploads/" . $nombre;

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)) {
        $ruta = "uploads/" . $nombre;
        mysqli_query($con, "INSERT INTO documentos_causa (id_causa, nombre_archivo, ruta)
                            VALUES ('$id_causa', '$nombre', '$ruta')");
    }
}

header("Location: ver_archivos.php?id_causa=$id_causa");
exit;
?>