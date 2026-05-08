<?php

session_start();




include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}



?>


<!DOCTYPE html>
<html>
    <head>
         <link rel="stylesheet" href="../css/otro.css">
         <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas Atenciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    </head>
    <body>
       
          <a href="estadisticas.php" class="btn btn-primary">
           <i class='fas fa-angle-double-left'>Volver</i>
             </a>
        <iframe title="juridica_atenciones" width="600" height="373.5" src="https://app.powerbi.com/view?r=eyJrIjoiYWFhYmNmMjItZWY2NC00OTQ5LTg0ZDctYjQwODcwM2FiYjAzIiwidCI6ImY0MDczNmRlLWI3YjYtNDI3Yi04YzMwLTAyODE1YmNhMjZiOSIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>

         
      
        </div>
       
    </body>
</html>