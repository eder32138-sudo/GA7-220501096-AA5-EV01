<?php
// Endpoint para validar las credenciales de inicio de sesión.
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/respuesta.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(405, ['estado' => 'error', 'mensaje' => 'Método no permitido. Use POST.']);
}

$datos = leerDatos();
$usuario = trim($datos['usuario'] ?? '');
$contrasena = $datos['contrasena'] ?? '';

if ($usuario === '' || !is_string($contrasena) || $contrasena === '') {
    responder(422, ['estado' => 'error', 'mensaje' => 'Debe enviar usuario y contraseña.']);
}

try {
    $conexion = obtenerConexion();

    // Se obtiene el hash asociado al usuario para verificar la contraseña.
    $consulta = $conexion->prepare(
        'SELECT id, usuario, contrasena_hash FROM usuarios WHERE usuario = :usuario LIMIT 1'
    );
    $consulta->execute(['usuario' => $usuario]);
    $registro = $consulta->fetch();

    if (!$registro || !password_verify($contrasena, $registro['contrasena_hash'])) {
        responder(401, ['estado' => 'error', 'mensaje' => 'Error en la autenticación.']);
    }

    responder(200, [
        'estado' => 'correcto',
        'mensaje' => 'Autenticación satisfactoria.',
        'usuario' => $registro['usuario']
    ]);
} catch (PDOException $error) {
    responder(500, ['estado' => 'error', 'mensaje' => 'No fue posible validar las credenciales.']);
}
