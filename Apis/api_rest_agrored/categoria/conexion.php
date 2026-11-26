<?php
//POD Crea objetos
$servidor = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "agrored_normalizado_3_t"; //base de datos que se usa para el proyecto

try {

    $conexion = new PDO(
        "mysql:host=$servidor;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $password
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    http_response_code(500);

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode([
        "error" => "No fue posible conectar con MySQL"
    ]);

    exit;
}