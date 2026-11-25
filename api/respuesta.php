<?php
// Envía todas las respuestas de la API en formato JSON.
function responder(int $estado, array $datos): void
{
    http_response_code($estado);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

// Lee el cuerpo JSON enviado por el cliente.
function leerDatos(): array
{
    $contenido = file_get_contents('php://input');
    $datos = json_decode($contenido, true);

    if (!is_array($datos)) {
        responder(400, [
            'estado' => 'error',
            'mensaje' => 'El cuerpo de la solicitud debe ser JSON válido.'
        ]);
    }

    return $datos;
}
