<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$tipos        = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM tipo_causa"), MYSQLI_ASSOC);
$resultados   = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM resultado_causa"), MYSQLI_ASSOC);
$responsables = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM responsables"), MYSQLI_ASSOC);
$categorias   = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM categoria"), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva Causa</title>
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

    <h2 class="text-center">Nueva Causa</h2>

      <div class="text-center fw-bold mb-3">
        
    <p class="text"><small> Se deben llenar todos los campos obligatorios *</small></p>
    </div>


    <form action="insert_causa.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id_usuario" id="id_usuario">

        <div class="mb-3">
            <label>RUT *</label>
            <input type="text" id="rut_input" class="form-control" placeholder="12345678-9" required>
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" id="nombre_usuario" class="form-control" readonly placeholder="Se completará automáticamente">
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" id="apellido_usuario" class="form-control" readonly placeholder="Se completará automáticamente">
        </div>

        <div class="mb-3">
            <label>RIT/ROL *</label>
            <input type="text" name="rit" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tipo Causa *</label>
            <select name="id_tipo_causa" class="form-select" id="selectTipoCausa" required>
                <option value="">-- Seleccione --</option>
                <?php foreach($tipos as $t): ?>
                    <option value="<?= $t['id_tipo_causa'] ?>"><?= $t['nombre_tipo_causa'] ?></option>
                <?php endforeach; ?>
                <option value="nueva">+ Agregar nuevo tipo</option>
            </select>
            <input type="text" class="form-control mt-2 d-none" id="nuevoTipoCausa"
                   name="nuevo_tipo_causa" placeholder="Nuevo tipo de causa" maxlength="100">
        </div>

        <script>
        document.getElementById('selectTipoCausa').addEventListener('change', function() {
            const input = document.getElementById('nuevoTipoCausa');
            if (this.value === 'nueva') {
                input.classList.remove('d-none');
                input.setAttribute('required', 'required');
            } else {
                input.classList.add('d-none');
                input.removeAttribute('required');
            }
        });
        </script>

        <div class="mb-3">
            <label>Categoría</label>
            <select name="id_categoria" class="form-select">
                <?php foreach($categorias as $c): ?>
                    <option value="<?= $c['id_categoria'] ?>"><?= $c['nombre_categoria'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Responsable</label>
            <select name="id_responsable" class="form-select">
                <?php foreach($responsables as $r): ?>
                    <option value="<?= $r['id_responsable'] ?>"><?= $r['nombre_responsable'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Resultado</label>
            <select name="id_resultado" class="form-select">
                <?php foreach($resultados as $r): ?>
                    <option value="<?= $r['id_resultado_causa'] ?>"><?= $r['nombre_resultado_causa'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Archivo</label>
            <input type="file" name="archivo" class="form-control">
        </div>

        <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control"></textarea>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="causas.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>

<script>
document.getElementById('rut_input').addEventListener('input', function() {
    let valor = this.value.replace(/[^0-9kK]/g, '');
    if (valor.length > 1) {
        valor = valor.slice(0, -1) + '-' + valor.slice(-1);
    }
    this.value = valor;
});

document.getElementById('rut_input').addEventListener('blur', function() {
    const rut = this.value.trim();
    if (!rut) return;

    fetch('../buscar_usuario.php?rut=' + rut)
        .then(res => res.json())
        .then(data => {
            if (data.encontrado) {
                document.getElementById('nombre_usuario').value   = data.nombres;
                document.getElementById('apellido_usuario').value = data.apellidos;
                document.getElementById('id_usuario').value       = data.id_usuario;
            } else {
                alert('Usuario no encontrado');
                document.getElementById('nombre_usuario').value   = '';
                document.getElementById('apellido_usuario').value = '';
                document.getElementById('id_usuario').value       = '';
            }
        });
});

document.querySelector('form').addEventListener('submit', function(e) {
    if (!document.getElementById('id_usuario').value) {
        e.preventDefault();
        alert('Debe ingresar un RUT válido y registrado.');
    }
});
</script>

</body>
</html>