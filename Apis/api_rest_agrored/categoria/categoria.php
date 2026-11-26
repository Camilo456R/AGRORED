<?php
require_once "conexion.php";

$metodo = $_SERVER['REQUEST_METHOD'] ?? '';
header("Content-Type: application/json; charset=utf-8");

try {

    // CONSULTAR CATEGORIA
    if ($metodo === "GET") {

        $sql = "SELECT * FROM categoria";

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

        // CASO 1: ELIMINAR PACIENTE (Si en la URL mandas ?accion=eliminar)
        if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {

            $idCategoria = $datos["id_categoria"] ?? $datos["id_categoria"] ?? null;

            if (!is_array($datos) || empty($idCategoria)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "ID de la categiria requerido para eliminar"
                ]);
                exit;
            }

            $sql = "DELETE FROM categoria WHERE id_categoria = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$idCategoria]);

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode([
                    "exito" => "Categoria eliminada correctamente."
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "error" => "No se encontró ninguna categiria con ese ID"
                ]);
            }

            exit;
        }

        // CASO 2: REGISTRAR CATEGORIA (Funcionamiento normal)
        if (
            !is_array($datos) ||
            empty($datos["id_categoria"]) ||
            empty($datos["nombre"]) ||
            empty($datos["tipo"])
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "Datos de la categoria incompletos para registrar"
            ]);
            exit;
        }

        $sql = "INSERT INTO categoria
                (id_categoria, tipo, nombre)
                VALUES (:id, :nombre, :tipo)";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":id" => $datos["id_categoria"],
            ":tipo" => $datos["tipo"],
            ":nombre" => $datos["nombre"],
        ]);

        http_response_code(201);
        echo json_encode([
            "mensaje" => "Categoría registrado correctamente"
        ]);

    }

    // ACTUALIZAR CATEGORIA
    elseif ($metodo === "PUT") {

        $datos = json_decode(
            file_get_contents("php://input"),
            true
        );

        $idCategoria = $datos["id_categoria"] ?? $datos["id_categoria"] ?? null;
        $tipo   = $datos["tipo"] ?? $datos["tipo"] ?? null;
        $nombre     = $datos["nombre"] ?? $datos["nombre"] ?? null;

        if (
            !is_array($datos) ||
            empty($idCategoria) ||
            empty($tipo) ||
            empty($nombre)
        ) {
            http_response_code(400);

            echo json_encode([
                "error" => "Datos de la cotegoria incompletos"
            ]);

            exit;
        }

        $sql = "UPDATE categoria
                SET tipo = :tipo,
                    Nombre = :nombre
                WHERE id_categoria = :id";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":id"       => $idCategoria,
            ":tipo" => $tipo,
            ":nombre"   => $nombre,
        ]);

        if ($consulta->rowCount() > 0) {
            http_response_code(200);

            echo json_encode([
                "mensaje" => "Categoria actualizado correctamente"
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