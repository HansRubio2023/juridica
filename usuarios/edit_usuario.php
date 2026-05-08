<?php

session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

// ==========================
// RECIBIR DATOS
// ==========================
$id_usuario = $_POST['id_usuario'] ?? '';
$rutCompleto = $_POST['rut'] ?? '';
$nombres = $_POST['nombres'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$email = $_POST['email'] ?? '';
$celular = $_POST['celular'] ?? '';
$telefono_fijo = $_POST['telefono_fijo'] ?? '';
$id_estado_civil = $_POST['id_estado_civil'] ?? NULL;
$id_comuna = $_POST['id_comuna'] ?? NULL;
$domicilio = $_POST['domicilio'] ?? '';
$sector = $_POST['sector'] ?? '';

// ==========================
// SEPARAR RUT Y DV
// ==========================
$rutCompleto = str_replace(".", "", $rutCompleto);

if (!strpos($rutCompleto, '-')) {
    die("Formato de RUT inválido");
}

list($rut, $dv) = explode("-", $rutCompleto);
$dv = strtolower($dv);

// ==========================
// NUEVA COMUNA
// ==========================
if ($id_comuna === 'nueva' && !empty($_POST['nueva_comuna'])) {
    $nueva_comuna = $_POST['nueva_comuna'];
    mysqli_query($con, "INSERT INTO comunas (nombre_comuna) VALUES ('$nueva_comuna')");
    $id_comuna = mysqli_insert_id($con);
}

// ==========================
// UPDATE
// ==========================
$sql = "UPDATE usuarios SET 
        rut='$rut', 
        dv='$dv',
        nombres='$nombres', 
        apellidos='$apellidos', 
        email='$email', 
        celular='$celular', 
        telefono_fijo='$telefono_fijo', 
        id_estado_civil=" . ($id_estado_civil ? "'$id_estado_civil'" : "NULL") . ", 
        domicilio='$domicilio', 
        id_comuna=" . ($id_comuna ? "'$id_comuna'" : "NULL") . ", 
        sector='$sector' 
        WHERE id_usuario='$id_usuario'";

$query = mysqli_query($con, $sql);

// ==========================
// RESULTADO
// ==========================
if ($query) {
    header("Location: usuarios.php");
    exit;
} else {
    echo "Error de SQL: " . mysqli_error($con);
}
?>