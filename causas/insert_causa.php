<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$rit            = $_POST['rit'] ?? '';
$id_usuario     = $_POST['id_usuario'] ?? '';
$id_tipo_causa  = $_POST['id_tipo_causa'] ?? NULL;
$id_categoria   = $_POST['id_categoria'] ?? NULL;
$id_responsable = $_POST['id_responsable'] ?? NULL;
$id_resultado   = $_POST['id_resultado'] ?? NULL;
$observaciones  = $_POST['observaciones'] ?? '';

if (empty($rit) || empty($id_usuario)) {
    die("Faltan campos obligatorios");
}

// Nueva tipo causa
if ($id_tipo_causa === 'nueva' && !empty($_POST['nuevo_tipo_causa'])) {
    $nuevo_tipo = $_POST['nuevo_tipo_causa'];
    mysqli_query($con, "INSERT INTO tipo_causa (nombre_tipo_causa) VALUES ('$nuevo_tipo')");
    $id_tipo_causa = mysqli_insert_id($con);
}

$sql = "INSERT INTO causas (
            rit, id_usuario, id_tipo_causa, id_categoria,
            id_responsable, id_resultado, observaciones
        ) VALUES (
            '$rit',
            '$id_usuario',
            " . ($id_tipo_causa ? "'$id_tipo_causa'" : "NULL") . ",
            " . ($id_categoria ? "'$id_categoria'" : "NULL") . ",
            " . ($id_responsable ? "'$id_responsable'" : "NULL") . ",
            " . ($id_resultado ? "'$id_resultado'" : "NULL") . ",
            '$observaciones'
        )";

$result = mysqli_query($con, $sql);

if ($result) {
    $id_causa_nueva = mysqli_insert_id($con);

    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $nombre  = time() . '_' . basename($_FILES['archivo']['name']);
        $destino = "../uploads/" . $nombre;
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)) {
            $ruta = "uploads/" . $nombre;
            mysqli_query($con, "INSERT INTO documentos_causa (id_causa, nombre_archivo, ruta)
                                VALUES ('$id_causa_nueva', '$nombre', '$ruta')");
        }
    }

    header("Location: causas.php");
    exit;
} else {
    echo "Error al insertar: " . mysqli_error($con);
}




?>