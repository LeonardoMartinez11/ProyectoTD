<?php
require_once __DIR__ . "/../bd/Conexion.php";

class ModelChoferes
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new ConexionSupabase();
    }

    // ✅ Obtener lista de choferes
    public function obtenerChoferes()
    {
        $endpoint = "/choferes";
        $respuesta = $this->conexion->request("GET", $endpoint);

        if (!is_array($respuesta)) {
            return [];
        }

        return $respuesta;
    }

    // ✅ Crear chofer
    public function crearChofer($data)
    {
        $payload = [
            'nombre' => $data['nombre'] ?? '',
            'dpi' => $data['dpi'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'licencia' => $data['licencia'] ?? null,
            'activo' => isset($data['activo']) ? boolval($data['activo']) : true
        ];

        return $this->conexion->request("POST", "/choferes", [$payload]);
    }

    // ✅ Actualizar chofer
    public function actualizarChofer($id_chofer, $data)
    {
        $payload = [];
        if (isset($data['nombre'])) $payload['nombre'] = $data['nombre'];
        if (isset($data['dpi'])) $payload['dpi'] = $data['dpi'];
        if (isset($data['telefono'])) $payload['telefono'] = $data['telefono'];
        if (isset($data['direccion'])) $payload['direccion'] = $data['direccion'];
        if (isset($data['licencia'])) $payload['licencia'] = $data['licencia'];
        if (isset($data['activo'])) $payload['activo'] = boolval($data['activo']);

        $endpoint = "/choferes?id_chofer=eq." . intval($id_chofer);
        return $this->conexion->request("PATCH", $endpoint, $payload);
    }

    // ✅ Eliminar chofer
    public function eliminarChofer($id_chofer)
    {
        $endpoint = "/choferes?id_chofer=eq." . intval($id_chofer);
        return $this->conexion->request("DELETE", $endpoint);
    }
}
?>
