<?php 
session_start();
include("conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
   header("Location: index.php");
    exit;
}
$id = $_POST['id'];
$mail = $_POST['email'];
$password = $_POST['contrasena'];
$password=password_hash($password, PASSWORD_DEFAULT);
$usuario = $_POST['usuario'];
$rol = $_POST['rol'];



$verificar = "SELECT * FROM perfiles WHERE email = '$mail' AND id != '$id'";
    $resultado = mysqli_query($con, $verificar);
if(mysqli_num_rows($resultado) > 0) {
        header("Location: nuevo_perfil.php?id=$id&error=email_exists");
        exit();
    }

$sql = "INSERT INTO perfiles (email, contrasena, usuario, rol) VALUES ('$mail', '$password', '$usuario', '$rol')";
$query = mysqli_query($con, $sql);
if($query){
    Header("Location: perfiles.php");
}else {
    echo "Error al insertar el perfil";
}




?>