<?php
header("Content-Type: application/json; charset=utf-8");
require_once "Conexion.php";

$metodo = $_SERVER["REQUEST_METHOD"];

try {
   
    if ($metodo === "GET") {
        if (isset($_GET["id_producto"])) {
            $sql = "SELECT id_producto, id_categoria FROM producto_categoria WHERE id_producto = :id_producto";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([":id_producto" => $_GET["id_producto"]]);
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } elseif (isset($_GET["id_categoria"])) {
            $sql = "SELECT id_producto, id_categoria FROM producto_categoria WHERE id_categoria = :id_categoria";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([":id_categoria" => $_GET["id_categoria"]]);
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT id_producto, id_categoria FROM producto_categoria";
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($resultado);

   
    } elseif ($metodo === "POST") {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!is_array($datos) || empty($datos["id_producto"]) || empty($datos["id_categoria"])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios (id_producto, id_categoria)"]);
            exit;
        }

        $sql = "INSERT INTO producto_categoria (id_producto, id_categoria) 
                VALUES (:id_producto, :id_categoria)";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([
            ":id_producto"  => $datos["id_producto"],
            ":id_categoria" => $datos["id_categoria"]
        ]);

        http_response_code(201);
        echo json_encode(["mensaje" => "Categoría asignada al producto correctamente"]);

  
    } elseif ($metodo === "PUT") {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (
            !is_array($datos) ||
            empty($datos["id_producto"]) ||
            empty($datos["id_categoria_actual"]) ||
            empty($datos["id_categoria_nueva"])
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "Faltan datos obligatorios (id_producto, id_categoria_actual, id_categoria_nueva)"
            ]);
            exit;
        }

        $sql = "UPDATE producto_categoria 
                SET id_categoria = :id_categoria_nueva 
                WHERE id_producto = :id_producto AND id_categoria = :id_categoria_actual";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([
            ":id_categoria_nueva"  => $datos["id_categoria_nueva"],
            ":id_producto"         => $datos["id_producto"],
            ":id_categoria_actual" => $datos["id_categoria_actual"]
        ]);

        if ($consulta->rowCount() > 0) {
            echo json_encode(["mensaje" => "Categoría del producto actualizada correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No se encontró esa relación producto-categoría o no hubo cambios"]);
        }

   
    } elseif ($metodo === "DELETE") {
        $id_producto  = $_GET["id_producto"] ?? null;
        $id_categoria = $_GET["id_categoria"] ?? null;

        if (empty($id_producto) || empty($id_categoria)) {
            http_response_code(400);
            echo json_encode(["error" => "Debe proporcionar id_producto e id_categoria en la URL"]);
            exit;
        }

        $sql = "DELETE FROM producto_categoria 
                WHERE id_producto = :id_producto AND id_categoria = :id_categoria";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([
            ":id_producto"  => $id_producto,
            ":id_categoria" => $id_categoria
        ]);

        if ($consulta->rowCount() > 0) {
            echo json_encode(["mensaje" => "Categoría desvinculada del producto correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No se encontró la relación especificada"]);
        }

    } else {
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error"   => "Error en la base de datos",
        "detalle" => $e->getMessage()
    ]);
}
?>
