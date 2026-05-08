<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id_usuario'])) {
    $id = intval($_GET['id_usuario']);

    // Verificar si tiene causas asociadas
    $causas = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM causas WHERE id_usuario = $id"));

    if ($causas['total'] > 0) {
        $_SESSION['error_usuario'] = "No se puede eliminar este usuario porque tiene registros asociados.";
        header("Location: usuarios.php");
        exit;
    }

    $sql  = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: usuarios.php");
        exit;
    } else {
        echo "Error al eliminar: " . mysqli_error($con);
    }
}
?>
