<?php
// Endpoint para registrar un usuario nuevo.
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

if (mb_strlen($usuario) < 3 || mb_strlen($usuario) > 50) {
    responder(422, ['estado' => 'error', 'mensaje' => 'El usuario debe tener entre 3 y 50 caracteres.']);
}

if (strlen($contrasena) < 8) {
    responder(422, ['estado' => 'error', 'mensaje' => 'La contraseña debe tener al menos 8 caracteres.']);
}

try {
    $conexion = obtenerConexion();

    // Se consulta primero para responder de forma clara si el usuario ya existe.
    $consulta = $conexion->prepare('SELECT id FROM usuarios WHERE usuario = :usuario LIMIT 1');
    $consulta->execute(['usuario' => $usuario]);

    if ($consulta->fetch()) {
        responder(409, ['estado' => 'error', 'mensaje' => 'El usuario ya se encuentra registrado.']);
    }

    // La contraseña se guarda como hash y no como texto plano.
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $insertar = $conexion->prepare(
        'INSERT INTO usuarios (usuario, contrasena_hash) VALUES (:usuario, :hash)'
    );
    $insertar->execute(['usuario' => $usuario, 'hash' => $hash]);

    responder(201, [
        'estado' => 'correcto',
        'mensaje' => 'Usuario registrado satisfactoriamente.'
    ]);
} catch (PDOException $error) {
    // En producción no se deben mostrar detalles internos de la base de datos.
    responder(500, ['estado' => 'error', 'mensaje' => 'No fue posible completar el registro.']);
}
