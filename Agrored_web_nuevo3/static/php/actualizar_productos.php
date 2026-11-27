<?php
    require 'conexion_inicial.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { die("Método no permitido"); }

    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
    $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $nombre = trim($_POST['nombre'] ?? '');
    $descripccion = trim($_POST['descripccion'] ?? '');
    $estado_producto = trim($_POST['estado_producto'] ?? '');
    $stock = trim($_POST['stock'] ?? '');
    $precio = trim($_POST['precio'] ?? '');


    if (!$id_producto || $nombre === '' || $precio === '') {
        die("Datos inválidos");
}

    $sql = "UPDATE productos SET
            id_usuario = :id_usuario, nombre = :nombre, estado_producto = :estado_producto, descripccion = :descripccion,
            stock = :stock, precio = :precio";



    $params = [
        ':id_usuario' => 1, ':nombre' => $nombre,
        ':estado_producto' => $estado_producto, ':descripccion' => $descripccion,
        ':stock' => $stock, ':precio' => $precio,
        ':id_producto'     => $id_producto 
    ];


    $sql .= " WHERE id_producto = :id_producto";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: /Agrored_web_nuevo3/static/php/listado_productos.php");
    exit;
?>
