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

// Datos de la causa
$res_causa = mysqli_query($con, "SELECT c.*, CONCAT(u.rut, '-', u.dv) AS rut_completo, 
                                  CONCAT(u.nombres, ' ', u.apellidos) AS usuario
                                  FROM causas c
                                  LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
                                  WHERE c.id_causa = '$id_causa'");
$causa = mysqli_fetch_assoc($res_causa);

// Archivos de la causa
$docs = mysqli_fetch_all(mysqli_query($con, 
    "SELECT * FROM documentos_causa WHERE id_causa = '$id_causa' ORDER BY fecha_subida DESC"), 
    MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Archivos de Causa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/panel_usuario.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<a id="inicio" href="causas.php">
    <i class="fas fa-arrow-left btn-icon"></i> Volver
</a>
<a id="cerrar_sesion" href="../logout.php">
    <i class="fas fa-sign-out-alt btn-icon"></i> Cerrar Sesión
</a>

<h1>Archivos de Causa</h1>

<div class="card-body">

    <!-- Datos de la causa -->
    <div class="mb-4">
        <p><strong>RUT:</strong> <?= $causa['rut_completo'] ?></p>
        <p><strong>Usuario:</strong> <?= $causa['usuario'] ?></p>
        <p><strong>RIT/ROL:</strong> <?= $causa['rit'] ?></p>
    </div>

    <!-- Subir nuevo archivo -->
    <form action="subir_archivo.php" method="POST" enctype="multipart/form-data" class="mb-4">
        <input type="hidden" name="id_causa" value="<?= $id_causa ?>">
        <div class="row align-items-end">
            <div class="col-md-8">
                <label class="form-label fw-bold">Subir nuevo archivo</label>
                <input type="file" name="archivo" class="form-control" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-upload"></i> Subir
                </button>
            </div>
        </div>
    </form>

    <!-- Lista de archivos -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Archivo</th>
                    <th>Fecha subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($docs)): ?>
                <tr>
                    <td colspan="3" class="text-center">No hay archivos subidos</td>
                </tr>
                <?php else: ?>
                <?php foreach($docs as $doc): ?>
                <tr>
                    <td><i class="fas fa-file me-2"></i><?= $doc['nombre_archivo'] ?></td>
                    <td><?= $doc['fecha_subida'] ?></td>
                    <td class="acciones">
                        <a href="../uploads/<?= $doc['nombre_archivo'] ?>" 
                           target="_blank" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if (($_SESSION['rol'] === 'admin'|| $_SESSION['rol']=== 'usuario' )): ?>
                        <a href="eliminar_archivo.php?id_documento=<?= $doc['id_documento'] ?>&id_causa=<?= $id_causa ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar este archivo?');">
                            <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>