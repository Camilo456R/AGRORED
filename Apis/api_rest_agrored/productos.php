<?php
header("Content-Type: application/json; charset=utf-8");
require_once "Conexion.php";

$metodo = $_SERVER["REQUEST_METHOD"];

try {
    if ($metodo === "GET") {
        if (isset($_GET["id_producto"])) {
            $sql = "SELECT id_producto, id_usuario, nombre, estado_producto, descripccion, stock, precio 
                    FROM productos 
                    WHERE id_producto = :id";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([":id" => $_GET["id_producto"]]);
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        } elseif (isset($_GET["id_usuario"])) {
            $sql = "SELECT id_producto, id_usuario, nombre, estado_producto, descripccion, stock, precio 
                    FROM productos 
                    WHERE id_usuario = :id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([":id_usuario" => $_GET["id_usuario"]]);
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT id_producto, id_usuario, nombre, estado_producto, descripccion, stock, precio 
                    FROM productos";
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($resultado);

    } elseif ($metodo === "POST") {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (
            !is_array($datos) ||
            empty($datos["nombre"]) ||
            !isset($datos["stock"]) ||
            !isset($datos["precio"])
        ) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios (nombre, stock, precio)"]);
            exit;
        }

        $sql = "INSERT INTO productos (id_usuario, nombre, estado_producto, descripccion, stock, precio) 
                VALUES (:id_usuario, :nombre, :estado_producto, :descripccion, :stock, :precio)";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([
            ":id_usuario"      => $datos["id_usuario"] ?? null,
            ":nombre"          => $datos["nombre"],
            ":estado_producto" => $datos["estado_producto"] ?? "Disponible",
            ":descripccion"    => $datos["descripccion"] ?? null,
            ":stock"           => $datos["stock"],
            ":precio"          => $datos["precio"]
        ]);

        http_response_code(201);
        echo json_encode([
            "mensaje"     => "Producto registrado correctamente",
            "id_producto" => $conexion->lastInsertId()
        ]);

    } elseif ($metodo === "PUT") {
        $datos = json_decode(file_get_contents("php://input"), true);
        $id = $_GET["id_producto"] ?? $datos["id_producto"] ?? null;

        if (
            empty($id) ||
            !is_array($datos) ||
            empty($datos["nombre"]) ||
            !isset($datos["stock"]) ||
            !isset($datos["precio"])
        ) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios (id_producto, nombre, stock, precio)"]);
            exit;
        }

        $sql = "UPDATE productos 
                SET id_usuario = :id_usuario,
                    nombre = :nombre,
                    estado_producto = :estado_producto,
                    descripccion = :descripccion,
                    stock = :stock,
                    precio = :precio
                WHERE id_producto = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([
            ":id"              => $id,
            ":id_usuario"      => $datos["id_usuario"] ?? null,
            ":nombre"          => $datos["nombre"],
            ":estado_producto" => $datos["estado_producto"] ?? "Disponible",
            ":descripccion"    => $datos["descripccion"] ?? null,
            ":stock"           => $datos["stock"],
            ":precio"          => $datos["precio"]
        ]);

        if ($consulta->rowCount() > 0) {
            echo json_encode(["mensaje" => "Producto actualizado correctamente"]);
        } else {
            echo json_encode(["mensaje" => "No se realizaron cambios o el producto no existe"]);
        }

    } elseif ($metodo === "DELETE") {
        $id = $_GET["id_producto"] ?? null;

        if (empty($id)) {
            http_response_code(400);
            echo json_encode(["error" => "Debe proporcionar el id_producto"]);
            exit;
        }

        $sql = "DELETE FROM productos WHERE id_producto = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([":id" => $id]);

        if ($consulta->rowCount() > 0) {
            echo json_encode(["mensaje" => "Producto eliminado correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No se encontró el producto"]);
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
