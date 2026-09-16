<?php
    $host = "localhost:3308";
    $usuario = "root";
    $password = "";
    $base_datos = "prueba_conexiones";

    try {
        // Conexión con PDO
        $conexion = new PDO("mysql:host=$host;dbname=$base_datos;charset=utf8", $usuario, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>