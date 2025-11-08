<?php
require_once __DIR__ . "/../bd/Conexion.php";

class ModelUnidades {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionSupabase();
    }

    // 🔹 Obtener lista de unidades
    public function obtenerUnidades() {
        $endpoint = "/unidades?select=id_unidad,placa,marca,modelo,anio,capacidad_toneladas,kilometraje,fecha_ultimo_mantenimiento,consumo_combustible,estado";
        $response = $this->conexion->request("GET", $endpoint);
        return isset($response["error"]) ? [] : $response;
    }

    // 🔹 Obtener lista de estados (para desplegar texto en vez de id)
    public function obtenerEstadosUnidad() {
        $endpoint = "/estadosunidad?select=id_estado,descripcion";
        $response = $this->conexion->request("GET", $endpoint);
        return isset($response["error"]) ? [] : $response;
    }

    // 🔹 Crear nueva unidad
public function crearUnidad($data) {
    $payload = [
        'placa'                      => $data['placa'] ?? null,
        'marca'                      => $data['marca'] ?? null,
        'modelo'                     => $data['modelo'] ?? null,
        'anio'                       => isset($data['anio']) ? intval($data['anio']) : null,
        'capacidad_toneladas'        => isset($data['capacidad_toneladas']) ? floatval($data['capacidad_toneladas']) : null,
        'kilometraje'                => isset($data['kilometraje']) ? intval($data['kilometraje']) : 0,
        'fecha_ultimo_mantenimiento' => $data['fecha_ultimo_mantenimiento'] ?: null,
        'consumo_combustible'        => isset($data['consumo_combustible']) ? floatval($data['consumo_combustible']) : null,
        'estado'                     => isset($data['estado']) ? intval($data['estado']) : 1
    ];

    // Enviar como objeto plano, igual que con usuarios
    return $this->conexion->request("POST", "/unidades", $payload);
}


 // 🔹 Actualizar unidad
public function actualizarUnidad($id_unidad, $data) {
    // Asegurarse que el endpoint tenga la query correcta
    $endpoint = "/unidades?id_unidad=eq." . intval($id_unidad);

    // Construir payload solo con campos no vacíos
    $payload = [];
    foreach ($data as $key => $value) {
        if ($value !== null && $value !== "") {
            // Convierte los números si corresponde
            if (in_array($key, ['anio','kilometraje','estado'])) {
                $payload[$key] = intval($value);
            } elseif (in_array($key, ['capacidad_toneladas','consumo_combustible'])) {
                $payload[$key] = floatval($value);
            } else {
                $payload[$key] = $value;
            }
        }
    }

    return $this->conexion->request("PATCH", $endpoint, $payload);
}

 // 🔹 Eliminar unidad
    public function eliminarUnidad($id_unidad) {
        $endpoint = "/unidades?id_unidad=eq." . intval($id_unidad);
        return $this->conexion->request("DELETE", $endpoint);
    }

}

?>
