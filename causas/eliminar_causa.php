<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id_causa'])) {
    $id = intval($_GET['id_causa']);

    // Verificar si tiene archivos asociados
    $archivos = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM documentos_causa WHERE id_causa = $id"));

    // Verificar si tiene atenciones asociadas
    $atenciones = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM atenciones WHERE id_causa = $id"));

    if ($archivos['total'] > 0 || $atenciones['total'] > 0) {
        $_SESSION['error_causa'] = "No se puede eliminar esta causa porque tiene archivos o atenciones asociados.";
        header("Location: causas.php");
        exit;
    }

    $sql  = "DELETE FROM causas WHERE id_causa = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: causas.php");
        exit;
    } else {
        echo "Error al eliminar: " . mysqli_error($con);
    }
}
?>
