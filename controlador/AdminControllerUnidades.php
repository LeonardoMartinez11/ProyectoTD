<?php
require_once __DIR__ . "/../modelo/AdminModelUnidades.php";

class ControllerUnidades
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelUnidades();
    }

    // Obtener todas las unidades
    public function listarUnidades()
    {
        return $this->model->obtenerUnidades();
    }

    // **Nuevo método para estados**
    public function listarEstadosUnidad()
    {
        return $this->model->obtenerEstadosUnidad();
    }

    // Crear nueva unidad (recibe $_POST o arreglo con datos)
    public function crearUnidad($data)
    {
        if (!empty($data)) {
            $resultado = $this->model->crearUnidad($data);
            // Devuelve true si se creó correctamente, o el error si falló
            if (isset($resultado['error'])) {
                return ['error' => $resultado['error']];
            }
            return true;
        }
        return false;
    }

    // 🔹 Actualizar unidad
    public function actualizarUnidad($id_unidad, $data)
    {
        if (!empty($id_unidad) && !empty($data)) {
            return $this->model->actualizarUnidad($id_unidad, $data);
        }
        return false;
    }

    // Eliminar unidad
    public function eliminarUnidad($id_unidad) {
        if (!empty($id_unidad)) {
            return $this->model->eliminarUnidad($id_unidad);
        }
        return false;
    }
}
?>