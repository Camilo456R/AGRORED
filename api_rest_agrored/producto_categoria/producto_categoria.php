<?php
require_once "conexion.php";

$metodo = $_SERVER['REQUEST_METHOD'] ?? '';
header("Content-Type: application/json; charset=utf-8");

try {

    // CONSULTAR PRODUCTO CATEGORIA
    if ($metodo === "GET") {

        $sql = "SELECT p.nombre, c.tipo, pc.id_categoria, pc.id_producto 
        FROM producto_categoria pc JOIN productos p 
        ON pc.id_producto = p.id_producto JOIN categoria c 
        ON pc.id_categoria = c.id_categoria";

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
        
        if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {

            $idProducto = $datos["id_producto"] ?? $datos["id_producto"] ?? null;
            $idCategoria = $datos["id_categoria"] ?? $datos["id_categoria"] ?? null;


            if (!is_array($datos) || empty($idProducto) || empty($idCategoria)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "ID de la categoría y/o producto requerido para eliminar"
                ]);
                exit;
            }

            $sql = "DELETE FROM producto_categoria WHERE id_categoria = ? and id_producto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$idCategoria, $idProducto]);

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode([
                    "exito" => "Producto eliminado de la categoría correctamente."
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "error" => "No se encontró ningún producto en esa categoría"
                ]);
            }

            exit;
        }

        if (
            !is_array($datos) ||
            empty($datos["id_categoria"]) ||
            empty($datos["id_producto"]) 
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "Datos de la categoria incompletos para registrar"
            ]);
            exit;
        }

        $sql = "INSERT INTO producto_categoria
                (id_categoria, id_producto)
                VALUES (:id_categoria, :id_producto)";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":id_categoria" => $datos["id_categoria"],
            ":id_producto" => $datos["id_producto"]
        ]);

        http_response_code(201);
        echo json_encode([
            "mensaje" => "producto registrado en categoría correctamente"
        ]);

    }

  // ACTUALIZAR CATEGORIA
    elseif ($metodo === "PUT") {

        $datos = json_decode(
            file_get_contents("php://input"),
            true
        );

        $idCategoriaNueva = $datos["id_categoria"] ?? null;
        $idProductoNuevo  = $datos["id_producto"] ?? null;
        $idCategoriaVieja = $datos["id_categoria_anterior"] ?? $idCategoriaNueva;
        $idProductoViejo  = $datos["id_producto_anterior"] ?? $idProductoNuevo;

        if (
            !is_array($datos) ||
            empty($idCategoriaNueva) ||
            empty($idProductoNuevo)
        ) {
            http_response_code(400);
            echo json_encode([
                "error" => "Datos de la actualización incompletos"
            ]);
            exit;
        }

        // 1. Verificar si existe el registro original
        $sqlCheck = "SELECT 1 FROM producto_categoria
                     WHERE id_categoria = :vieja_categoria
                       AND id_producto = :viejo_producto";
        $stmtCheck = $conexion->prepare($sqlCheck);
        $stmtCheck->execute([
            ":vieja_categoria" => $idCategoriaVieja,
            ":viejo_producto"  => $idProductoViejo,
        ]);

        if (!$stmtCheck->fetchColumn()) {
            http_response_code(404);
            echo json_encode([
                "error" => "No se encontró el registro original para actualizar"
            ]);
            exit;
        }

        // 2. Actualizar registro
        $sql = "UPDATE producto_categoria
                SET id_categoria = :nueva_categoria,
                    id_producto = :nuevo_producto
                WHERE id_categoria = :vieja_categoria
                  AND id_producto = :viejo_producto";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([
            ":nueva_categoria" => $idCategoriaNueva,
            ":nuevo_producto"  => $idProductoNuevo,
            ":vieja_categoria" => $idCategoriaVieja,
            ":viejo_producto"  => $idProductoViejo,
        ]);

        http_response_code(200);
        if ($consulta->rowCount() > 0) {
            echo json_encode([
                "mensaje" => "Categoría actualizada correctamente"
            ]);
        } else {
            echo json_encode([
                "mensaje" => "El registro ya tenía esos mismos valores (sin cambios)"
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