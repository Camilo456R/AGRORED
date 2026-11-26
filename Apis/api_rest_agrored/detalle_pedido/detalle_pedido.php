<?php
require_once "conexion.php";

$metodo = $_SERVER['REQUEST_METHOD'] ?? '';
header("Content-Type: application/json; charset=utf-8");

try {

    // CONSULTAR DETALLE PEDIDO con nombre de usuario, del producto y mas datos del pedido

    if ($metodo === "GET") {

        $sql = "SELECT 
        p.id_pedido,
        dc.id_producto,
        u.p_nombre,
        pr.nombre,
        dc.cantidad,
        dc.precio_unitario,
        p.estado
        FROM detalle_pedido dc
        JOIN pedido p ON dc.id_pedido = p.id_pedido
        JOIN usuario u ON p.id_usuario = u.id_usuario
        JOIN productos pr ON dc.id_producto = pr.id_producto;";

        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        $pacientes = $consulta->fetchAll(PDO::FETCH_ASSOC); //;P

        echo json_encode($pacientes);

    }

    // POST REGISTRAR 
    elseif ($metodo === "POST") {

        $datos = json_decode(
            file_get_contents("php://input"),
            true
        );

        // CASO 1: ELIMINAR PACIENTE (Si en la URL mandas ?accion=eliminar)
        if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {

            $idPedido = $datos["id_pedido"] ?? $datos["id_pedido"] ?? null;
            $idProducto = $datos["id_producto"] ?? $datos["id_producto"] ?? null;
            

            if (!is_array($datos) || empty($idPedido) || empty($idProducto)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "ID del producto y/o pedido requerido para eliminar"
                ]);
                exit;
            }

            $sql = "DELETE FROM detalle_pedido WHERE id_pedido = ? AND id_producto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$idPedido, $idProducto]);

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode([
                    "exito" => "Detalle del pedido eliminado correctamente."
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "error" => "No se encontró ningún detalle del pedido con esos IDs"
                ]);
            }

            exit;
        }


        if (
            !is_array($datos) ||
            empty($datos["id_pedido"]) ||
            empty($datos["id_producto"]) ||
            empty($datos["cantidad"]) ||
            empty($datos["precio_unitario"])
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "Datos del detalle del pedido incompletos para registrar"
            ]);
            exit;
        }

        $sql = "INSERT INTO detalle_pedido
                (id_pedido, id_producto, cantidad, precio_unitario)
                VALUES (:id_pedido, :id_producto, :cantidad, :precio_unitario)";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":id_pedido" => $datos["id_pedido"],
            ":id_producto" => $datos["id_producto"],
            ":cantidad" => $datos["cantidad"],
            ":precio_unitario" => $datos["precio_unitario"]
        ]);

        http_response_code(201);
        echo json_encode([
            "mensaje" => "Detalle del pedido registrado correctamente"
        ]);

    }

    // ACTUALIZAR DETALLE PEDIDO
    elseif ($metodo === "PUT") {

        $datos = json_decode(
            file_get_contents("php://input"),
            true
        );

        $idPedido = $datos["id_pedido"] ?? $datos["id_pedido"] ?? null;
        $idProducto   = $datos["id_producto"] ?? $datos["id_producto"] ?? null;
        $cantidad = $datos["cantidad"] ?? $datos["cantidad"] ?? null;
        $precioUnitario = $datos["precio_unitario"] ?? $datos["precio_unitario"] ?? null;

        if (
            !is_array($datos) ||
            empty($idPedido) ||
            empty($idProducto) ||
            empty($cantidad) ||
            empty($precioUnitario)
        ) {
            http_response_code(400);

            echo json_encode([
                "error" => "Datos de la inserción incompletos"
            ]);

            exit;
        }

        $sql = "UPDATE detalle_pedido
                SET cantidad = :cantidad, precio_unitario = :precio_unitario
                WHERE id_pedido = :id AND id_producto = :id_producto";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":id"       => $idPedido,
            ":id_producto" => $idProducto,
            ":cantidad" => $cantidad,
            ":precio_unitario" => $precioUnitario
        ]);

        if ($consulta->rowCount() > 0) {
            http_response_code(200);

            echo json_encode([
                "mensaje" => "Detalle del pedido actualizado correctamente"
            ]);
        } else {
            http_response_code(200);

            echo json_encode([
                "mensaje" => "No se modificó ningún registro. Verifique el ID o que los datos sean distintos a los actuales."
            ]);
        }

    }

    // CUALQUIER OTRO MÉTODO NO SOPORTADO
    else {

        http_response_code(405);
        echo json_encode([
            "error" => "Método HTTP no permitido"
        ]);

    }

} catch (PDOException $e) {

    http_response_code(500);
    echo json_encode([
        "error" => "No fue posible procesar la solicitud: " . $e->getMessage()
    ]);
}