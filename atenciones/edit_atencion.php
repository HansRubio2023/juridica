    <?php
    session_start();
    include("../conexion/conexion.php");
    $con = connection();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../index.php");
        exit;
    }

    $id_atencion    = $_POST['id_atencion'] ?? '';
    $id_usuario     = $_POST['id_usuario'] ?? '';
    $id_causa       = $_POST['id_causa'] ?? '';
    $responsable = $_POST['responsable'] ?? '';
    $fecha_atencion = $_POST['fecha_atencion'] ?? '';
    $comentarios    = $_POST['comentarios'] ?? '';

    if (empty($id_atencion)) {
        header("Location: atenciones.php");
        exit;
    }

    $sql = "UPDATE atenciones SET
                id_usuario     = '$id_usuario',
                id_causa       = '$id_causa',
                responsable = '$responsable',
                fecha_atencion = '$fecha_atencion',
                comentarios    = '$comentarios'
            WHERE id_atencion = '$id_atencion'";

    $result = mysqli_query($con, $sql);

    if ($result) {
        header("Location: atenciones.php");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($con);
    }
    ?>