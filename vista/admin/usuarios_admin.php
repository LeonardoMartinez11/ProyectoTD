<?php
// Asegúrate que la ruta al controlador sea correcta según tu estructura
require_once __DIR__ . "/../../controlador/AdminControllerUsuario.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../diseño/usuarios_admin.css">
</head>
<body>
    <a href="menu.php" class="btn">⬅ Volver</a>
    <h1>Gestión de Usuarios</h1>

    <?php if (!empty($mensaje)): ?>
        <div >
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <button id="btnAbrirModal" class="btn btn-agregar">➕ Nuevo usuario</button>

    <table>
        <thead>
            <tr >
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre completo</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= intval($u['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($u['nombre_usuario']) ?></td>
                        <td><?= htmlspecialchars($u['nombre_completo']) ?></td>
                        <td><?= htmlspecialchars($u['correo']) ?></td>
                        <td><?= htmlspecialchars($u['roles']['nombre_rol'] ?? 'Sin rol') ?></td>
                        <td><?= (isset($u['activo']) && $u['activo']) ? 'Sí' : 'No' ?></td>
                        <td>
                            <button class="btn btn-editar"
                                data-id="<?= intval($u['id_usuario']) ?>"
                                data-usuario="<?= htmlspecialchars($u['nombre_usuario']) ?>"
                                data-nombre="<?= htmlspecialchars($u['nombre_completo']) ?>"
                                data-correo="<?= htmlspecialchars($u['correo']) ?>"
                                data-rol="<?= intval($u['id_rol'] ?? 0) ?>"
                                data-activo="<?= (isset($u['activo']) && $u['activo']) ? '1' : '0' ?>">✏️</button>

                            <a class="btn btn-eliminar" href="usuarios_admin.php?eliminar=<?= intval($u['id_usuario']) ?>"
                               onclick="return confirm('¿Eliminar este usuario?')">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No hay usuarios registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal" id="modalUsuario" role="dialog" aria-hidden="true">
        <div class="modal-content" role="document">
            <span class="close" id="cerrarModal">&times;</span>
            <h3 id="tituloModal">Nuevo Usuario</h3>

            <!-- Formulario envía POST de forma tradicional -->
            <form method="POST" id="formUsuario">
                <input type="hidden" name="id_usuario" id="id_usuario">

                <div class="form-row">
                    <label for="nombre_usuario">Nombre de usuario</label>
                    <input type="text" name="nombre_usuario" id="nombre_usuario" required>
                </div>

                <div class="form-row">
                    <label for="nombre_completo">Nombre completo</label>
                    <input type="text" name="nombre_completo" id="nombre_completo" required>
                </div>

                <div class="form-row">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" id="correo" required>
                </div>

                <div class="form-row">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Ingresar nueva Contraseña">
                </div>

                <div class="form-row">
                    <label for="id_rol">Rol</label>
                    <select name="id_rol" id="id_rol" required>
                        <option value="">Seleccione...</option>
                        <?php if (!empty($roles) && is_array($roles)): ?>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= intval($r['id_rol']) ?>"><?= htmlspecialchars($r['nombre_rol']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-row">
                    <label><input type="checkbox" name="activo" id="activo" checked> Activo</label>
                </div>

                <div style="margin-top:12px;">
                    <button type="submit" class="btn btn-agregar" id="btnGuardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/usuarios_admin.js"></script>
</body>
</html>
