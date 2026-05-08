<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$id_documento = $_GET['id_documento'] ?? '';
$id_causa     = $_GET['id_causa'] ?? '';

if (empty($id_documento) || empty($id_causa)) {
    header("Location: causas.php");
    exit;
}

// Obtener ruta física antes de borrar
$doc = mysqli_fetch_assoc(mysqli_query($con,
    "SELECT ruta FROM documentos_causa WHERE id_documento = '$id_documento'"));

if ($doc) {
    $sql  = "DELETE FROM documentos_causa WHERE id_documento = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_documento);
    mysqli_stmt_execute($stmt);
}

header("Location: ver_archivos.php?id_causa=$id_causa");
exit;
?>