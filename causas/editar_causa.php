<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$id_causa = $_GET['id_causa'] ?? '';
if (empty($id_causa)) { header("Location: causas.php"); exit; }

$res = mysqli_query($con, "SELECT c.*,
                            CONCAT(u.rut, '-', u.dv) AS rut_completo,
                            u.nombres,
                            u.apellidos
                           FROM causas c
                           LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
                           WHERE c.id_causa = '$id_causa'");
$causa = mysqli_fetch_assoc($res);
if (!$causa) { header("Location: causas.php"); exit; }

$tipos        = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM tipo_causa"),      MYSQLI_ASSOC);
$resultados   = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM resultado_causa"), MYSQLI_ASSOC);
$responsables = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM responsables"),    MYSQLI_ASSOC);
$categorias   = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM categoria"),       MYSQLI_ASSOC);
$esEstudiante = $_SESSION['rol'] === 'estudiante';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Causa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/formulario.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
</head>

<body>

<a id="inicio" href="../menu.php" class="btn">
    <i class="fas fa-home btn-icon"></i> Inicio
</a>
<a id="cerrar_sesion" href="../logout.php" class="btn">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<div class="form-card">

    <h2 class="text-center">Editar Causa</h2>

      <div class="text-center fw-bold mb-3">
        
    <p class="text"><small> Se deben llenar todos los campos obligatorios *</small></p>
    </div>


    <form action="edit_causa.php" method="POST">

        <input type="hidden" name="id_causa"   value="<?= $causa['id_causa'] ?>">
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $causa['id_usuario'] ?>">

        <div class="mb-3">
    <label>RUT *</label>
    <input type="text" id="rut_input" class="form-control"
           value="<?= $causa['rut_completo'] ?>"
           <?= $_SESSION['rol'] === 'estudiante' ? 'readonly' : '' ?> required>
</div>
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" id="nombre_usuario" class="form-control" readonly
                   value="<?= $causa['nombres'] ?>">
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" id="apellido_usuario" class="form-control" readonly
                   value="<?= $causa['apellidos'] ?>">

        </div>

    <div class="mb-3">
    <label>RIT/ROL *</label>
    <input type="text" name="rit" class="form-control"
           value="<?= $causa['rit'] ?>"
           <?= $_SESSION['rol'] === 'estudiante' ? 'readonly' : '' ?> required>
</div>

        <div class="mb-3">
    <label>Tipo Causa *</label>
    <select name="id_tipo_causa" class="form-select" id="selectTipoCausa"
            <?= $_SESSION['rol'] === 'estudiante' ? 'disabled' : '' ?> required>
        <option value="">-- Seleccione --</option>
        <?php foreach($tipos as $t): ?>
            <option value="<?= $t['id_tipo_causa'] ?>"
                <?= $t['id_tipo_causa'] == $causa['id_tipo_causa'] ? 'selected' : '' ?>>
                <?= $t['nombre_tipo_causa'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if ($_SESSION['rol'] === 'estudiante'): ?>
        <input type="hidden" name="id_tipo_causa" value="<?= $causa['id_tipo_causa'] ?>">
    <?php endif; ?>
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

        document.querySelector('form').addEventListener('submit', function(e) {
    if (!document.getElementById('id_usuario').value) {
        e.preventDefault();
        alert('Debe ingresar un RUT válido.');
    }
});
        </script>

        <div class="mb-3">
    <label>Competencia</label>
    <select name="id_categoria" class="form-select" id="selectCategoria"
            <?= $_SESSION['rol'] === 'estudiante' ? 'disabled' : '' ?>>
        <option value="">-- Seleccione --</option>
        <?php foreach($categorias as $c): ?>
            <option value="<?= $c['id_categoria'] ?>"
                <?= $c['id_categoria'] == $causa['id_categoria'] ? 'selected' : '' ?>>
                <?= $c['nombre_categoria'] ?>
            </option>
        <?php endforeach; ?>
        <?php if ($_SESSION['rol'] !== 'estudiante'): ?>
            <option value="nueva">+ Agregar nueva competencia</option>
        <?php endif; ?>
    </select>
    <input type="text" class="form-control mt-2 d-none" id="nuevaCategoria"
           name="nueva_categoria" placeholder="Nueva competencia" maxlength="100">
    <?php if ($_SESSION['rol'] === 'estudiante'): ?>
        <input type="hidden" name="id_categoria" value="<?= $causa['id_categoria'] ?>">
    <?php endif; ?>
</div>



<!-- responsable -->
<div class="mb-3">
            <label>Responsable</label>
         <input type="text" name="responsable" class="form-control" value="<?= $_SESSION['usuario'] ?>"readonly>
        </div>

        <!-- Estados -->
        <div class="mb-3">
            <label>Estado</label>
            <select name="id_resultado" class="form-select"
                    <?= $_SESSION['rol'] === 'estudiante' ? 'disabled' : '' ?>>
                <?php foreach($resultados as $r): ?>
                    <option value="<?= $r['id_resultado_causa'] ?>"
                        <?= $r['id_resultado_causa'] == $causa['id_resultado'] ? 'selected' : '' ?>>
                        <?= $r['nombre_resultado_causa'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ($_SESSION['rol'] === 'estudiante'): ?>
                <input type="hidden" name="id_resultado" value="<?= $causa['id_resultado'] ?>">
            <?php endif; ?>
        </div>

        <!--Seguimiento -->
<div class="mb-3">
    <label>Seguimiento</label>
    <textarea name="observaciones" class="form-control" maxlength="500"><?= $causa['observaciones'] ?></textarea>
    <div class="textarea-counter">
        <span id="contador2">0</span>/500 caracteres
    </div>
</div>

        <script>
        // Contador de caracteres
         document.querySelectorAll('textarea').forEach(textarea => {
                                const contador = textarea.parentElement.querySelector('.textarea-counter span');
                                const max = textarea.maxLength;
                                
                                textarea.addEventListener('input', function() {
                                    let len = this.value.length;
                                    contador.textContent = len;
                                    
                                    if (len > max * 0.9) {
                                        contador.parentElement.style.color = '#dc3545';
                                    } else {
                                        contador.parentElement.style.color = '#6c757d';
                                    }
                                });
                            });
                        </script>

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

<?php if (!$esEstudiante): ?>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
new TomSelect('#selectCategoria', {
    create: false,
    maxOptions: false,
    sortField: { field: 'text', direction: 'asc' },
    onChange: function(value) {
        const input = document.getElementById('nuevaCategoria');
        if (value === 'nueva') {
            input.classList.remove('d-none');
            input.setAttribute('required', 'required');
        } else {
            input.classList.add('d-none');
            input.removeAttribute('required');
        }
    }
});
</script>
<?php endif; ?>
</body>
</html>
