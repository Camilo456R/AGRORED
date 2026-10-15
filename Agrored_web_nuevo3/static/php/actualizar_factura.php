<?php
    require 'conexion_inicial.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { die("Método no permitido"); }

    $id_factura    = filter_input(INPUT_POST, 'id_factura', FILTER_VALIDATE_INT);
    $id_pedido     = filter_input(INPUT_POST, 'id_pedido', FILTER_VALIDATE_INT);
    $id_pago       = filter_input(INPUT_POST, 'id_pago', FILTER_VALIDATE_INT);
    $fecha_emision = trim($_POST['fecha_emision'] ?? '');
    $id_usuario    = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);


    if (!$id_factura || !$id_pedido || !$id_pago || !$id_usuario || $fecha_emision === '') {
        die("Datos inválidos");
    }


    $sql = "UPDATE factura SET
                id_pedido = :id_pedido,
                id_pago = :id_pago,
                fecha_emision = :fecha_emision,
                id_usuario = :id_usuario
            WHERE id_factura = :id_factura";

    $params = [
        ':id_pedido'     => $id_pedido,
        ':id_pago'       => $id_pago,
        ':fecha_emision' => $fecha_emision,
        ':id_usuario'    => $id_usuario,
        ':id_factura'    => $id_factura
    ];


    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } catch (PDOException $e) {
        // Normalmente: el pedido, el pago o el usuario indicado no existe
        die("Error al actualizar: " . $e->getMessage());
    }

    header("Location: /Agrored_web_nuevo3/static/php/listado_facturas.php?mensaje=Factura actualizada correctamente");
    exit;
?>