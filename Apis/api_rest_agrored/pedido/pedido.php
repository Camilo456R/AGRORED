<?php
require_once "conexion.php";

$metodo = $_SERVER['REQUEST_METHOD'] ?? '';
header("Content-Type: application/json; charset=utf-8");

try {

    // CONSULTAR PEDIDO
    if ($metodo === "GET") {

        $sql = "SELECT p.id_pedido, u.P_nombre, p.estado
        FROM pedido p JOIN usuario u 
        ON p.id_usuario = u.id_usuario";

        $consulta = $conexion->prepare($sql);
        $consulta->execute();
        $pacientes = $consulta->fetchAll(PDO::FETCH_ASSOC); //;P

        echo json_encode($pacientes);

    }

    // MÉTODOS POST (REGISTRAR O ELIMINAR)
    elseif ($metodo === "POST") {

        $datos = json_decode(
            file_get_contents("php://input"),
            true
        );

        // CASO 1: ELIMINAR PEDIDO (Si en la URL mandas ?accion=eliminar)
        if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {

            $idPedido = $datos["id_pedido"] ?? $datos["id_pedido"] ?? null;

            if (!is_array($datos) || empty($idPedido)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "ID del pedido requerido para eliminar"
                ]);
                exit;
            }

            $sql = "DELETE FROM pedido WHERE id_pedido = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$idPedido]);

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode([
                    "exito" => "Pedido eliminado correctamente."
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "error" => "No se encontró ningún pedido con ese ID"
                ]);
            }

            exit;
        }

        // CASO 2: REGISTRAR PEDIDO (Funcionamiento normal)
        if (
            !is_array($datos) ||
            empty($datos["id_pedido"]) ||
            empty($datos["id_usuario"]) ||
            empty($datos["fecha_estado"]) ||
            empty($datos["estado"]) 
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "Datos del pedido incompletos para registrar"
            ]);
            exit;
        }

        $sql = "INSERT INTO pedido
                (id_pedido, id_usuario, fecha_estado, estado)
                VALUES (:id, :id_usuario, :fecha_estado, :estado)";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":id" => $datos["id_pedido"],
            ":id_usuario" => $datos["id_usuario"],
            ":fecha_estado" => $datos["fecha_estado"],
            ":estado" => $datos["estado"]
        ]);

        http_response_code(201);
        echo json_encode([
            "mensaje" => "Pedido registrado correctamente"
        ]);

    }

    // ACTUALIZAR PEDIDO
    elseif ($metodo === "PUT") {

        $datos = json_decode(
            file_get_contents("php://input"),
            true
        );

        $idPedido= $datos["id_pedido"] ?? $datos["id_pedido"] ?? null;
        $idUsuario   = $datos["id_usuario"] ?? $datos["id_usuario"] ?? null;
        $fechaEstado     = $datos["fecha_estado"] ?? $datos["fecha_estado"] ?? null;
        $estado     = $datos["estado"] ?? $datos["estado"] ?? null;

        if (
            !is_array($datos) ||
            empty($idPedido) ||
            empty($idUsuario) ||
            empty($fechaEstado) ||
            empty($estado)
        ) {
            http_response_code(400);

            echo json_encode([
                "error" => "Datos del pedido incompletos"
            ]);

            exit;
        }

        $sql = "UPDATE pedido
                SET id_usuario = :id_usuario,
                    fecha_estado = :fecha_estado,
                    estado = :estado
                WHERE id_pedido = :id";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":id"       => $idPedido,
            ":id_usuario" => $idUsuario,
            ":fecha_estado" => $fechaEstado,
            ":estado" => $estado,
        ]);

        if ($consulta->rowCount() > 0) {
            http_response_code(200);

            echo json_encode([
                "mensaje" => "Pedido actualizado correctamente"
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

?>