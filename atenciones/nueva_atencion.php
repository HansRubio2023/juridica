<?php
session_start();
include("../conexion/conexion.php");
$con = connection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

$causas       = mysqli_fetch_all(mysqli_query($con, "SELECT id_causa, id_usuario, rit FROM causas ORDER BY rit"), MYSQLI_ASSOC);
$responsables = mysqli_fetch_all(mysqli_query($con, "SELECT * FROM responsables ORDER BY nombre_responsable"), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva Atención</title>
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

    <h2 class="text-center">Nueva Atención</h2>

     <div class="text-center fw-bold mb-3">
        
    <p class="text"><small> Se deben llenar todos los campos obligatorios *</small></p>
    </div>


    <form action="insert_atencion.php" method="POST">

        <input type="hidden" name="id_usuario" id="id_usuario">

        <!-- RUT -->
        <div class="mb-3">
            <label>RUT</label>
            <input type="text" id="rut_input" class="form-control" placeholder="12345678-9">
        </div>

        <!-- Nombre -->
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" id="nombre_usuario" class="form-control" readonly placeholder="Se completará automáticamente">
        </div>

        <!-- Apellido -->
        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" id="apellido_usuario" class="form-control" readonly placeholder="Se completará automáticamente">
        </div>

        <!-- Causa -->
        <div class="mb-3">
            <label>Causa (RIT/ROL) *</label>
            <select name="id_causa" id="sel_causa" class="form-select" required>
                <option value="">Ingrese primero el rut</option>
                <?php foreach($causas as $c): ?>
                    <option value="<?= $c['id_causa'] ?>" data-usuario="<?= $c['id_usuario'] ?>" style="display:none">
                        <?= $c['rit'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Responsable -->
        <div class="mb-3">
            <label>Responsable *</label>
            <select name="id_responsable" class="form-select" required>
                <option value="">Seleccione</option>
                <?php foreach($responsables as $r): ?>
                    <option value="<?= $r['id_responsable'] ?>"><?= $r['nombre_responsable'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Fecha -->
        <div class="mb-3">
            <label>Fecha de atención *</label>
            <input type="text" name="fecha_atencion" id="fecha_atencion" class="form-control"
                   placeholder="Seleccione una fecha" required readonly>
        </div>

        <!-- Comentarios -->
        <div class="mb-3">
            <label>Comentarios</label>
            <textarea name="comentarios" class="form-control" rows="3"></textarea>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="atenciones.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>

<script>
const todasCausas = Array.from(document.querySelectorAll('#sel_causa option[data-usuario]'));

// Auto formato RUT
document.getElementById('rut_input').addEventListener('input', function() {
    let valor = this.value.replace(/[^0-9kK]/g, '');
    if (valor.length > 1) {
        valor = valor.slice(0, -1) + '-' + valor.slice(-1);
    }
    this.value = valor;
});

// Buscar usuario y filtrar causas
document.getElementById('rut_input').addEventListener('blur', function() {
    const rut = this.value.trim();
    if (!rut) return;

    fetch('../buscar_usuario.php?rut=' + rut)
        .then(res => res.json())
        .then(data => {
            if (data.encontrado) {
                document.getElementById('nombre_usuario').value = data.nombres;
                document.getElementById('apellido_usuario').value = data.apellidos;
                document.getElementById('id_usuario').value = data.id_usuario;

                // Filtrar causas
                const selCausa = document.getElementById('sel_causa');
                selCausa.innerHTML = '';
                const filtradas = todasCausas.filter(opt => opt.dataset.usuario === String(data.id_usuario));

                if (filtradas.length === 0) {
                    selCausa.innerHTML = '<option value="">Este usuario no tiene causas</option>';
                } else {
                    filtradas.forEach(opt => {
                        const nueva = opt.cloneNode(true);
                        nueva.style.display = '';
                        selCausa.appendChild(nueva);
                    });
                }
            } else {
                alert('Usuario no encontrado');
                document.getElementById('nombre_usuario').value = '';
                document.getElementById('apellido_usuario').value = '';
                document.getElementById('id_usuario').value = '';
                document.getElementById('sel_causa').innerHTML = '<option value="">Primero ingrese un RUT válido</option>';
            }
        });
});
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

    flatpickr("#fecha_atencion", {
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

document.querySelector('form').addEventListener('submit', function(e) {
    if (!document.getElementById('id_usuario').value) {
        e.preventDefault();
        alert('Debe ingresar un RUT válido y registrado.');
    }
});
</script>

</body>
</html>