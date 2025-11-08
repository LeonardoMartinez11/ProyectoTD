<?php
require_once __DIR__ . "/../modelo/AdminModelChoferes.php";

$model = new ModelChoferes();

$choferes = $model->obtenerChoferes();
$mensaje = "";

// Crear o actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    $data = [
        'nombre' => $_POST['nombre'] ?? '',
        'dpi' => $_POST['dpi'] ?? null,
        'telefono' => $_POST['telefono'] ?? null,
        'direccion' => $_POST['direccion'] ?? null,
        'licencia' => $_POST['licencia'] ?? null,
        'activo' => isset($_POST['activo']) ? boolval($_POST['activo']) : true
    ];

    if (!empty($_POST['id_chofer'])) {
        $id = intval($_POST['id_chofer']);
        $res = $model->actualizarChofer($id, $data);
        $mensaje = (is_array($res) && isset($res['error']))
            ? "Error al actualizar chofer: " . $res['error']
            : "Chofer actualizado correctamente.";
    } else {
        $res = $model->crearChofer($data);
        $mensaje = (is_array($res) && isset($res['error']))
            ? "Error al crear chofer: " . $res['error']
            : "Chofer creado correctamente.";
    }

    $choferes = $model->obtenerChoferes();
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $res = $model->eliminarChofer($id);
    $mensaje = (is_array($res) && isset($res['error']))
        ? "Error al eliminar chofer: " . $res['error']
        : "Chofer eliminado correctamente.";
    $choferes = $model->obtenerChoferes();
}
?>
