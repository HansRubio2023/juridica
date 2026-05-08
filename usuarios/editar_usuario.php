<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$row = [];
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $sql   = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
    $query = mysqli_query($con, $sql);
    $row   = mysqli_fetch_array($query);
    if (!$row) { header("Location: usuarios.php"); exit; }
} else {
    header("Location: usuarios.php");
    exit;
}

$sql_comunas = "SELECT * FROM comunas ORDER BY nombre_comuna";
$comunas = mysqli_fetch_all(mysqli_query($con, $sql_comunas), MYSQLI_ASSOC);

$sql_estado_civil = "SELECT * FROM estado_civil ORDER BY nombre_estado_civil";
$estado_civil = mysqli_fetch_all(mysqli_query($con, $sql_estado_civil), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/formulario.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<a id="inicio" href="../menu.php" class="btn">
    <i class="fas fa-home btn-icon"></i> Inicio
</a>
<a id="cerrar_sesion" href="../logout.php" class="btn">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<div class="form-card">

    <h2 class="text-center">
        <i class="fas fa-user-edit"></i> Editar Usuario
    </h2>

     <div class="text-center fw-bold mb-3">
        
    <p class="text"><small> Se deben llenar todos los campos obligatorios *</small></p>
    </div>


    <form method="POST" action="edit_usuario.php">
        <input type="hidden" name="id_usuario" value="<?= $row['id_usuario'] ?>">

        <div class="row">

            <!-- RUT -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">RUT *</label>
                <input type="text" class="form-control" name="rut" value="<?= $row['rut'] . '-' . $row['dv'] ?>" required>
            </div>

            <!-- Nombres -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nombres *</label>
                <input type="text" class="form-control" name="nombres" value="<?= $row['nombres'] ?>" required>
            </div>

            <!-- Apellidos -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Apellidos *</label>
                <input type="text" class="form-control" name="apellidos" value="<?= $row['apellidos'] ?>" required>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $row['email'] ?>">
            </div>

            <!-- Celular -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Celular</label>
                <input type="text" class="form-control" name="celular" value="<?= $row['celular'] ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                placeholder="923895560">
            </div>

            <!-- Teléfono fijo -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono fijo</label>
                <input type="text" class="form-control" name="telefono_fijo" value="<?= $row['telefono_fijo'] ?>" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            </div>

            <!-- Estado civil -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Estado Civil</label>
                <select class="form-select" name="id_estado_civil">
                    <option value="">Seleccione</option>
                    <?php foreach ($estado_civil as $e): ?>
                        <option value="<?= $e['id_estado_civil'] ?>" <?= $row['id_estado_civil'] == $e['id_estado_civil'] ? 'selected' : '' ?>>
                            <?= $e['nombre_estado_civil'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Comuna -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Comuna</label>
                <select class="form-select" name="id_comuna" id="selectComuna">
                    <option value="">Seleccione</option>
                    <?php foreach ($comunas as $c): ?>
                        <option value="<?= $c['id_comuna'] ?>" <?= $row['id_comuna'] == $c['id_comuna'] ? 'selected' : '' ?>>
                            <?= $c['nombre_comuna'] ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="nueva">+ Agregar nueva comuna</option>
                </select>
                <input type="text" class="form-control mt-2 d-none" id="nuevaComuna"
                       name="nueva_comuna" placeholder="Nueva comuna" maxlength="100">
            </div>

            <!-- Domicilio -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Domicilio</label>
                <input type="text" class="form-control" name="domicilio" value="<?= $row['domicilio'] ?>">
            </div>

            <!-- Sector -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Sector</label>
                <input type="text" class="form-control" name="sector" value="<?= $row['sector'] ?>">
            </div>

        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a href="usuarios.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Volver
            </a>
        </div>

    </form>
</div>

<script>
document.getElementById('selectComuna').addEventListener('change', function() {
    const input = document.getElementById('nuevaComuna');
    if (this.value === 'nueva') {
        input.classList.remove('d-none');
        input.setAttribute('required', 'required');
    } else {
        input.classList.add('d-none');
        input.removeAttribute('required');
    }
});
</script>

</body>
</html>