<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$id_causa       = $_POST['id_causa'] ?? '';
$id_usuario     = $_POST['id_usuario'] ?? '';
$rit            = $_POST['rit'] ?? '';
$id_tipo_causa  = $_POST['id_tipo_causa'] ?? NULL;
$id_categoria   = $_POST['id_categoria'] ?? NULL;
$responsable = $_POST['responsable'] ?? NULL;
$id_resultado   = $_POST['id_resultado'] ?? NULL;
$observaciones  = $_POST['observaciones'] ?? '';

if (empty($id_causa)) {
    header("Location: causas.php");
    exit;
}

// Nueva tipo causa
if ($id_tipo_causa === 'nueva' && !empty($_POST['nuevo_tipo_causa'])) {
    $nuevo_tipo = $_POST['nuevo_tipo_causa'];
    mysqli_query($con, "INSERT INTO tipo_causa (nombre_tipo_causa) VALUES ('$nuevo_tipo')");
    $id_tipo_causa = mysqli_insert_id($con);
}

// Nueva competencia
if ($id_categoria === 'nueva' && !empty($_POST['nueva_categoria'])) {
    $nueva_cat = $_POST['nueva_categoria'];
    mysqli_query($con, "INSERT INTO categoria (nombre_categoria) VALUES ('$nueva_cat')");
    $id_categoria = mysqli_insert_id($con);
}

$sql = "UPDATE causas SET
            rit            = '$rit',
            id_usuario     = '$id_usuario',
            id_tipo_causa  = '$id_tipo_causa',
            id_categoria   = '$id_categoria',
            responsable = '$responsable',
            id_resultado   = '$id_resultado',
            observaciones  = '$observaciones'
        WHERE id_causa = '$id_causa'";

$result = mysqli_query($con, $sql);

if ($result) {
    header("Location: causas.php");
    exit;
} else {
    echo "Error al actualizar: " . mysqli_error($con);
}
?>