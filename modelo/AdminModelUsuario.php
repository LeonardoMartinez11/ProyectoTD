<?php
require_once __DIR__ . "/../bd/Conexion.php";

class ModelUsuarios {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionSupabase();
    }

    // Obtener lista de usuarios (incluye rol e id_rol)
    public function obtenerUsuarios() {
        $endpoint = "/usuarios?select=id_usuario,nombre_usuario,nombre_completo,correo,password_hash,id_rol,activo,roles(nombre_rol)";
        return $this->conexion->request("GET", $endpoint);
    }

    // Obtener lista de roles
    public function obtenerRoles() {
        return $this->conexion->request("GET", "/roles?select=id_rol,nombre_rol");
    }

    // Crear usuario (POST)
    public function crearUsuario($data) {
        // Espera $data ya con password_hash si aplica
        $payload = [
            'nombre_usuario'  => $data['nombre_usuario'] ?? null,
            'nombre_completo' => $data['nombre_completo'] ?? null,
            'correo'          => $data['correo'] ?? null,
            'password_hash'   => $data['password_hash'] ?? null,
            'id_rol'          => isset($data['id_rol']) ? intval($data['id_rol']) : null,
            'activo'          => isset($data['activo']) ? (bool)$data['activo'] : true
        ];

        // Supabase REST expects array for batch insert; keep consistent with your other model usage
        return $this->conexion->request("POST", "/usuarios", [$payload]);
    }

    // Actualizar usuario (PATCH)
    public function actualizarUsuario($id_usuario, $data) {
        // Construir payload solo con campos a actualizar
        $payload = [];

        if (isset($data['nombre_usuario'])) $payload['nombre_usuario'] = $data['nombre_usuario'];
        if (isset($data['nombre_completo'])) $payload['nombre_completo'] = $data['nombre_completo'];
        if (isset($data['correo'])) $payload['correo'] = $data['correo'];
        if (isset($data['password_hash'])) $payload['password_hash'] = $data['password_hash'];
        if (isset($data['id_rol'])) $payload['id_rol'] = intval($data['id_rol']);
        if (isset($data['activo'])) $payload['activo'] = (bool)$data['activo'];

        $endpoint = "/usuarios?id_usuario=eq." . intval($id_usuario);
        return $this->conexion->request("PATCH", $endpoint, $payload);
    }

    // Eliminar usuario
    public function eliminarUsuario($id_usuario) {
        $endpoint = "/usuarios?id_usuario=eq." . intval($id_usuario);
        return $this->conexion->request("DELETE", $endpoint);
    }
}
?>
