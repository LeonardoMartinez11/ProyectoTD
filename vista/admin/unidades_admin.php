<?php
require_once __DIR__ . "/../../controlador/AdminControllerUnidades.php";

$controller = new ControllerUnidades();
$unidades = $controller->listarUnidades();
$estados = $controller->listarEstadosUnidad();

$mensaje = '';

// 🚨 Procesar eliminación si viene por GET
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    $resultado = $controller->eliminarUnidad($idEliminar);

    $mensaje = isset($resultado['error']) 
        ? "Error al eliminar unidad." 
        : "Unidad eliminada correctamente.";

    $unidades = $controller->listarUnidades(); // actualizar lista
}

// Procesar creación o actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placa'])) {
    if (!empty($_POST['id_unidad'])) {
        $resultado = $controller->actualizarUnidad($_POST['id_unidad'], $_POST);
        $mensaje = ($resultado) ? "Unidad actualizada correctamente." : "Error al actualizar unidad.";
    } else {
        $resultado = $controller->crearUnidad($_POST);
        $mensaje = ($resultado) ? "Unidad creada correctamente." : "Error al crear unidad.";
    }
    $unidades = $controller->listarUnidades(); // actualizar lista
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Unidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../diseño/unidades_admin.css">
</head>
<body>
<a href="menu.php" class="btn">⬅ Volver</a>
<h2>Gestión de Unidades</h2>

<?php if ($mensaje): ?>
    <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <script>
        // Limpiar la URL sin recargar la página
        history.replaceState(null, '', 'unidades_admin.php');
    </script>
<?php endif; ?>

<button id="btnAbrirModal" class="btn btn-agregar">➕ Nueva unidad</button>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Capacidad (Ton)</th>
            <th>Kilometraje</th>
            <th>Último Mant.</th>
            <th>Consumo (Km/Gal)</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($unidades) && count($unidades) > 0): ?>
            <?php foreach ($unidades as $u): ?>
                <?php
                    $estadoTexto = '';
                    foreach ($estados as $e) {
                        if ($e['id_estado'] == $u['estado']) {
                            $estadoTexto = $e['descripcion'];
                            break;
                        }
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($u['id_unidad']) ?></td>
                    <td><?= htmlspecialchars($u['placa']) ?></td>
                    <td><?= htmlspecialchars($u['marca']) ?></td>
                    <td><?= htmlspecialchars($u['modelo']) ?></td>
                    <td><?= htmlspecialchars($u['anio']) ?></td>
                    <td><?= htmlspecialchars($u['capacidad_toneladas']) ?></td>
                    <td><?= htmlspecialchars($u['kilometraje']) ?></td>
                    <td><?= htmlspecialchars($u['fecha_ultimo_mantenimiento']) ?></td>
                    <td><?= htmlspecialchars($u['consumo_combustible']) ?></td>
                    <td><?= htmlspecialchars($estadoTexto) ?></td>
                    <td>
                        <button class="btn btn-editar"
                            data-id="<?= $u['id_unidad'] ?>"
                            data-placa="<?= htmlspecialchars($u['placa']) ?>"
                            data-marca="<?= htmlspecialchars($u['marca']) ?>"
                            data-modelo="<?= htmlspecialchars($u['modelo']) ?>"
                            data-anio="<?= htmlspecialchars($u['anio']) ?>"
                            data-capacidad="<?= htmlspecialchars($u['capacidad_toneladas']) ?>"
                            data-kilometraje="<?= htmlspecialchars($u['kilometraje']) ?>"
                            data-fecha="<?= htmlspecialchars($u['fecha_ultimo_mantenimiento']) ?>"
                            data-consumo="<?= htmlspecialchars($u['consumo_combustible']) ?>"
                            data-estado="<?= htmlspecialchars($u['estado']) ?>">✏️</button>

                        <a class="btn btn-eliminar"
                           href="unidades_admin.php?eliminar=<?= $u['id_unidad'] ?>"
                           onclick="return confirm('¿Eliminar esta unidad?')">🗑️</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="11">No se encontraron unidades registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal" id="modalUnidad">
    <div class="modal-content">
        <span id="cerrarModal" class="close">&times;</span>
        <h3>Nueva Unidad</h3>
        <form method="POST" id="formUnidad">
            <div>
                <label for="placa">Placa</label>
                <input type="text" name="placa" id="placa" required>
            </div>
            <div>
                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca">
            </div>
            <div>
                <label for="modelo">Modelo</label>
                <input type="text" name="modelo" id="modelo">
            </div>
            <div>
                <label for="anio">Año</label>
                <input type="number" name="anio" id="anio" min="1970" max="2100">
            </div>
            <div>
                <label for="capacidad_toneladas">Capacidad (Ton)</label>
                <input type="number" name="capacidad_toneladas" id="capacidad_toneladas" step="0.01">
            </div>
            <div>
                <label for="kilometraje">Kilometraje</label>
                <input type="number" name="kilometraje" id="kilometraje" value="0">
            </div>
            <div>
                <label for="fecha_ultimo_mantenimiento">Último Mant.</label>
                <input type="date" name="fecha_ultimo_mantenimiento" id="fecha_ultimo_mantenimiento">
            </div>
            <div>
                <label for="consumo_combustible">Consumo (Km/Gal)</label>
                <input type="number" name="consumo_combustible" id="consumo_combustible" step="0.01">
            </div>
            <div>
                <label for="estado">Estado</label>
                <select name="estado" id="estado" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $e): ?>
                        <option value="<?= intval($e['id_estado']) ?>"><?= htmlspecialchars($e['descripcion']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-top:10px;">
                <button type="submit" class="btn btn-agregar">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/unidades_admin.js"></script>
</body>
</html>
