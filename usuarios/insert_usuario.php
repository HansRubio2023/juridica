<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

// ==========================
// RECIBIR DATOS
// ==========================
$rutCompleto = $_POST['rut'] ?? '';
$nombres = $_POST['nombres'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$email = $_POST['email'] ?? '';
$celular = $_POST['celular'] ?? '';
$telefono_fijo = $_POST['telefono_fijo'] ?? '';
$id_estado_civil = $_POST['id_estado_civil'] ?? NULL;
$id_comuna = $_POST['id_comuna'] ?? NULL;
$domicilio = $_POST['domicilio'] ?? '';
$sector        = $_POST['sector'] ?? '';
$comentario = $_POST['comentario'] ?? '';
$fecha_ingreso = $_POST['fecha_ingreso'] ?? date('Y-m-d');

// ==========================
// LIMPIAR Y SEPARAR RUT
// ==========================
$rutCompleto = str_replace(".", "", $rutCompleto);

if (!strpos($rutCompleto, '-')) {
    die("Formato de RUT inválido");
}

list($rut, $dv) = explode("-", $rutCompleto);
$dv = strtolower($dv);

// ==========================
// VALIDAR CAMPOS
// ==========================
if (empty($rut) || empty($dv) || empty($nombres) || empty($apellidos)) {
    $_SESSION['error'] = "Todos los campos obligatorios deben completarse.";
    header("Location: nuevo_usuario.php");
    exit;
}

// ==========================
// NUEVA COMUNA
// ==========================
if ($id_comuna === 'nueva' && !empty($_POST['nueva_comuna'])) {
    $nueva_comuna = $_POST['nueva_comuna'];
    mysqli_query($con, "INSERT INTO comunas (nombre_comuna) VALUES ('$nueva_comuna')");
    $id_comuna = mysqli_insert_id($con);
}

// ==========================
// EVITAR RUT DUPLICADO
// ==========================
$check = mysqli_query($con, "SELECT * FROM usuarios WHERE rut = '$rut'");
if (mysqli_num_rows($check) > 0) {
    $_SESSION['error'] = "El RUT ingresado ya está registrado.";
    header("Location: nuevo_usuario.php");
    exit;
}

// ==========================
// INSERT
// ==========================
$sql = "INSERT INTO usuarios (
            rut, dv, nombres, apellidos, email, celular,
            telefono_fijo, id_estado_civil, domicilio, id_comuna, sector, fecha_ingreso,comentarios
        ) VALUES (
            '$rut', '$dv', '$nombres', '$apellidos', '$email', '$celular',
            '$telefono_fijo', " . ($id_estado_civil ? "'$id_estado_civil'" : "NULL") . ",
            '$domicilio', " . ($id_comuna ? "'$id_comuna'" : "NULL") . ",
            '$sector', '$fecha_ingreso', '$comentario'
        )";

$result = mysqli_query($con, $sql);

// ==========================
// RESULTADO
// ==========================
if ($result) {
    header("Location: usuarios.php");
    exit;
} else {
    echo "Error al insertar: " . mysqli_error($con);
}
?>