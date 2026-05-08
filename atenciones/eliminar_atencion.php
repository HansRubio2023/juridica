<?php
// Incluye tu conexión (asegúrate de que el nombre sea correcto)
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}
if (isset($_GET['id_atencion'])) {
    $id = $_GET['id_atencion'];



    // Usamos una sentencia preparada para proteger la base de datos
    $sql = "DELETE FROM atenciones WHERE id_atencion = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    mysqli_stmt_bind_param($stmt, "i", $id); // "i" significa que el ID es un entero (integer)

    if (mysqli_stmt_execute($stmt)) {
    // Cambia index.php por el nombre real de tu archivo de lista
    header("Location: atenciones.php"); 
    exit(); // Siempre añade exit después de un header
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($con);
    }
}
?>