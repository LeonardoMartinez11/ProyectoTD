<?php
require_once __DIR__ . "/../../controlador/AdminControllerChoferes.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Choferes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../diseño/choferes_admin.css">
</head>
<body>
    <a href="menu.php" class="btn">⬅ Volver</a>
    <h1>Gestión de Choferes</h1>

    <?php if (!empty($mensaje)) : ?>
        <div><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <button id="btnAbrirModal" class="btn btn-agregar">➕ Nuevo Chofer</button>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DPI</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Licencia</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($choferes) && is_array($choferes)) : ?>
                <?php foreach ($choferes as $c) : ?>
                    <tr>
                        <td><?= intval($c['id_chofer']) ?></td>
                        <td><?= htmlspecialchars($c['nombre']) ?></td>
                        <td><?= htmlspecialchars($c['dpi'] ?? '') ?></td>
                        <td><?= htmlspecialchars($c['telefono'] ?? '') ?></td>
                        <td><?= htmlspecialchars($c['direccion'] ?? '') ?></td>
                        <td><?= htmlspecialchars($c['licencia'] ?? '') ?></td>
                        <td><?= isset($c['activo']) && $c['activo'] ? 'Sí' : 'No' ?></td>
                        <td>
                            <button class="btn-editar"
                                data-id="<?= intval($c['id_chofer']) ?>"
                                data-nombre="<?= htmlspecialchars($c['nombre']) ?>"
                                data-dpi="<?= htmlspecialchars($c['dpi'] ?? '') ?>"
                                data-telefono="<?= htmlspecialchars($c['telefono'] ?? '') ?>"
                                data-direccion="<?= htmlspecialchars($c['direccion'] ?? '') ?>"
                                data-licencia="<?= htmlspecialchars($c['licencia'] ?? '') ?>"
                                data-activo="<?= isset($c['activo']) && $c['activo'] ? 1 : 0 ?>">
                                ✏️
                            </button>
                            <a href="?eliminar=<?= intval($c['id_chofer']) ?>" onclick="return confirm('¿Eliminar chofer?')">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8">No hay choferes registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal" id="modalChofer" role="dialog" aria-hidden="true">
        <div class="modal-content" role="document">
            <span class="close" id="cerrarModal">&times;</span>
            <h3 id="tituloModal">Nuevo Chofer</h3>

            <form method="POST" id="formChofer">
                <input type="hidden" name="id_chofer" id="id_chofer">

                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" required>

                <label>DPI</label>
                <input type="text" name="dpi" id="dpi">

                <label>Teléfono</label>
                <input type="text" name="telefono" id="telefono">

                <label>Dirección</label>
                <input type="text" name="direccion" id="direccion">

                <label>Licencia</label>
                <input type="text" name="licencia" id="licencia">

                <label><input type="checkbox" name="activo" id="activo" checked> Activo</label>

                <button type="submit">Guardar Chofer</button>
            </form>
        </div>
    </div>

    <script src="../js/choferes_admin.js"></script>
</body>
</html>
