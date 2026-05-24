<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$sql_comunas = "SELECT * FROM comunas ORDER BY nombre_comuna";
$comunas = mysqli_fetch_all(mysqli_query($con, $sql_comunas), MYSQLI_ASSOC);
$sql_estados_civiles = "SELECT * FROM estado_civil ORDER BY nombre_estado_civil";
$estados_civiles = mysqli_fetch_all(mysqli_query($con, $sql_estados_civiles), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nuevo Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/formulario.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .flatpickr-day.feriado, .flatpickr-day.domingo { background-color: #dc3545 !important; color: white !important; }
    .flatpickr-day.feriado:hover, .flatpickr-day.domingo:hover { background-color: #bb2d3b !important; }
</style>
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
        <i class="fas fa-user-plus"></i> Nuevo Usuario
    </h2>
    <div class="text-center fw-bold mb-3">
        
    <p class="text"><small> Se deben llenar todos los campos obligatorios *</small></p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="insert_usuario.php">
        <div class="row">

            <!-- RUT -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">RUT *</label>
                <input type="text" class="form-control" id="rut" name="rut" placeholder="12.345.678-7" required>
                <div class="invalid-feedback">RUT inválido</div>
            </div>

            <!-- Nombres -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nombres *</label>
                <input type="text" class="form-control" name="nombres" required>
            </div>

            <!-- Apellidos -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Apellidos *</label>
                <input type="text" class="form-control" name="apellidos" required>
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
            </div>

            <!-- Celular -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Celular *</label>
                <input type="text" class="form-control" name="celular" oninput="this.value=this.value.replace(/[^0-9]/g,'')"  placeholder="923895560" required>
            </div>

            <!-- Teléfono fijo -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono fijo</label>
                <input type="text" class="form-control" name="telefono_fijo" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
               >
            </div>

            <!-- Estado civil -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Estado Civil</label>
                <select class="form-select" name="id_estado_civil">
                    <option value="">-- Seleccione --</option>
                    <?php foreach ($estados_civiles as $e): ?>
                        <option value="<?= $e['id_estado_civil'] ?>"><?= $e['nombre_estado_civil'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Comuna -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Comuna</label>
                <select class="form-select" name="id_comuna" id="selectComuna">
                    <option value="">-- Seleccione --</option>
                    <?php foreach ($comunas as $c): ?>
                        <option value="<?= $c['id_comuna'] ?>"><?= $c['nombre_comuna'] ?></option>
                    <?php endforeach; ?>
                    <option value="nueva">+ Agregar nueva comuna</option>
                </select>
                <input type="text" class="form-control mt-2 d-none" id="nuevaComuna"
                       name="nueva_comuna" placeholder="Nueva comuna" maxlength="100">
            </div>

            <!-- Domicilio -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Domicilio</label>
                <input type="text" class="form-control" name="domicilio">
            </div>

            <!-- Sector -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Sector</label>
                <input type="text" class="form-control" name="sector">
            </div>

            <!-- Fecha de ingreso -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Fecha de Ingreso *</label>
                <input type="text" class="form-control" name="fecha_ingreso" id="fecha_ingreso"
                       placeholder="Seleccione una fecha" required readonly>
            </div>

            <!-- Comentarios -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Comentarios</label>
             <textarea name="comentarios" class="form-control" maxlength="500"></textarea>
    <div class="textarea-counter">
        <span id="contador2">0</span>/500 caracteres
            </div>
<script>
    const textarea = document.querySelector('textarea[name="comentarios"]');
    const contador = document.getElementById('contador2');

    contador.textContent = textarea.value.length;

    textarea.addEventListener('input', function() {
        contador.textContent = this.value.length;
        contador.style.color = this.value.length > 450 ? '#dc3545' : '#6c757d';
    });
</script>
            <!-- BOTONES -->
            <div class="d-flex justify-content-between mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="usuarios.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>

        </div>
    </form>
</div>

<script>

    // Mostrar u ocultar campo para nueva comuna
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

// Validación de RUT con formato en tiempo real
document.getElementById('rut').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\./g, '').replace('-', '');

    if (/^\d{7,8}[0-9kK]$/.test(value)) {
        value = value.replace(/^(\d+)(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
    }
    e.target.value = value;

    if (validarRut(value)) {
        e.target.setCustomValidity("");
        e.target.classList.remove('is-invalid');
    } else {
        e.target.setCustomValidity("RUT inválido");
        e.target.classList.add('is-invalid');
    }
});

function validarRut(rutCompleto) {
    if (!/^[0-9]+[-|‐][0-9kK]{1}$/.test(rutCompleto.replace(/\./g, ''))) return false;
    let tmp = rutCompleto.split('-');
    let digv = tmp[1].toLowerCase();
    let rut = tmp[0].replace(/\./g, '');
    return dv(rut) == digv;
}

function dv(T) {
    let M = 0, S = 1;
    for (; T; T = Math.floor(T / 10)) {
        S = (S + T % 10 * (9 - M++ % 6)) % 11;
    }
    return S ? S - 1 : 'k';
}
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
async function initFlatpickr() {
    let feriados = {};
    const y = new Date().getFullYear();
    try {
        for (const año of [y, y + 1]) {
            const data = await (await fetch(`https://feriados-cl.netlify.app/api/holidays/${año}`)).json();
            Object.values(data.feriados).flat().forEach(f => {
                feriados[`${año}-${String(f.mes).padStart(2,'0')}-${String(f.dia).padStart(2,'0')}`] = f.descripcion;
            });
        }
    } catch(e) {}

    flatpickr("#fecha_ingreso", {
        locale: "es",
        dateFormat: "Y-m-d",
        defaultDate: "today",
        disable: [
            function(date) { return date.getDay() === 0; },
            ...Object.keys(feriados)
        ],
        onDayCreate: (_, __, ___, day) => {
            const fecha = day.dateObj.toISOString().split('T')[0];
            if (feriados[fecha]) {
                day.classList.add('feriado');
                day.title = feriados[fecha];
            }
            if (day.dateObj.getDay() === 0) {
                day.classList.add('domingo');
            }
        }
    });
}
initFlatpickr();
</script>

</body>
</html>