<?php

// Creamos una función de conexión a la base de datos
function connection()
{
    //Creamos las variables de conexión y los parametros
    $host="127.0.0.1";
    $user="root";
    $pass="1234";

    // Vamos a definir una variable para la base de datos
    $bd="clinica_juridica";

    //Definir una variable para la conexión a la base de datos
    //Definir el método de conexión mysqli_connect()
    $connect = mysqli_connect($host, $user, $pass);

    //Seleccionar la base de datos y la conexión
    mysqli_select_db($connect, $bd);
    
    //Vamos a retornar la conexión de la variable connect 
    return $connect;   
};

/*
$mi_conexion = connection();
if(!$mi_conexion)
{
   //Mostrar un mensaje de conexión no existosa
   echo "Conexión no es existosa: " 
   . mysqli_connect_error();
    return null;
}

echo "<h3>Mostrando resultado de la conexión:</h3> 
<h2>Conexión exitosa</h2>";
*/
?>