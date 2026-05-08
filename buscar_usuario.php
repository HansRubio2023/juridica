<?php
session_start();
include("conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$rut = $_GET['rut'] ?? '';

$rut    = str_replace('.', '', $rut);
$partes = explode('-', $rut);
$num    = $partes[0] ?? '';
$dv     = strtolower($partes[1] ?? '');

if (empty($num) || empty($dv)) {
    echo json_encode(['encontrado' => false]);
    exit;
}

$res  = mysqli_query($con, "SELECT id_usuario, nombres, apellidos FROM usuarios WHERE rut='$num' AND dv='$dv'");
$user = mysqli_fetch_assoc($res);

if ($user) {
    echo json_encode([
        'encontrado' => true,
        'id_usuario' => $user['id_usuario'],
        'nombres'    => $user['nombres'],
        'apellidos'  => $user['apellidos']
    ]);
} else {
    echo json_encode(['encontrado' => false]);
}
?>