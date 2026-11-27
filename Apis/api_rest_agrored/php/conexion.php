<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "agrored_normalizado_3_t";


try {
    $conexion = new PDO(
        "mysql:host=$servidor;dbname=$base_datos;charset=utf8mb4",
        $usuario,
        $password
    );
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode([
        "error" => "No fue posible conectar con MySQL"
    ]);
    exit;
}