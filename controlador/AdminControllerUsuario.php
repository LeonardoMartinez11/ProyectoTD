<?php
require_once __DIR__ . "/../modelo/AdminModelUsuario.php";

$model = new ModelUsuarios();

// Datos para selects / tabla
$usuarios = $model->obtenerUsuarios();
$roles = $model->obtenerRoles();

$mensaje = "";

// CREAR o ACTUALIZAR via FORM POST (envío tradicional)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_usuario'])) {

    // Armar datos básicos
    $data = [
        "nombre_usuario"  => $_POST['nombre_usuario'] ?? '',
        "nombre_completo" => $_POST['nombre_completo'] ?? '',
        "correo"          => $_POST['correo'] ?? '',
        "id_rol"          => $_POST['id_rol'] ?? null,
        "activo"          => isset($_POST['activo']) ? 1 : 0
    ];

    // Si se proporcionó contraseña, encriptarla y asignar a password_hash
    if (!empty($_POST['password'])) {
        $data['password_hash'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }

    if (!empty($_POST['id_usuario'])) {
        // Actualizar
        $id = intval($_POST['id_usuario']);
        $res = $model->actualizarUsuario($id, $data);

        if (is_array($res) && isset($res['error'])) {
            $mensaje = "Error al actualizar: " . $res['error'];
        } else {
            $mensaje = "Usuario actualizado correctamente.";
        }
    } else {
        // Crear
        $res = $model->crearUsuario($data);

        if (is_array($res) && isset($res['error'])) {
            $mensaje = "Error al crear: " . $res['error'];
        } else {
            $mensaje = "Usuario creado correctamente.";
        }
    }

    // Recargar listas para vista (con los cambios)
    $usuarios = $model->obtenerUsuarios();
    $roles = $model->obtenerRoles();
}

// ELIMINAR via GET ?eliminar=ID (mismo patrón de ViajeController)
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $res = $model->eliminarUsuario($id);

    if (is_array($res) && isset($res['error'])) {
        $mensaje = "Error al eliminar: " . $res['error'];
    } else {
        $mensaje = "Usuario eliminado correctamente.";
    }

    // Recargar lista
    $usuarios = $model->obtenerUsuarios();
    $roles = $model->obtenerRoles();
}
?>
