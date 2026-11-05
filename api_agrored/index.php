<?php

// Permitir peticiones desde aplicaciones React locales.
$origen = $_SERVER['HTTP_ORIGIN'] ?? '';

$origenesPermitidos = [
    'http://localhost:3000',
    'http://localhost:5173',
    'http://127.0.0.1:3000',
    'http://127.0.0.1:5173'
];

if (in_array($origen, $origenesPermitidos, true)) {
    header("Access-Control-Allow-Origin: $origen");
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Responder a las peticiones preliminares del navegador.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'error' => 'Método no permitido'
    ]);
    exit;
}

try {
    // Conexión a MySQL de XAMPP.
    $conexion = new PDO(
        'mysql:host=localhost;dbname=agrored_normalizado_3_t;charset=utf8mb4',
        'root',
        ''
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // Consultar los artículos.
    $consulta = $conexion->query(
        'SELECT *
         FROM usuario
         ORDER BY id_usuario'
    );

    $usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);

    // Enviar la respuesta en formato JSON.
    echo json_encode(
        $usuarios,
        JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT 
    );

} catch (Throwable $error) {
    http_response_code(500);

    // Registrar el detalle en el registro de errores del servidor.
    error_log($error->getMessage());

    echo json_encode([
        'error' => 'No fue posible consultar los usuarios'
    ]);
}

?>