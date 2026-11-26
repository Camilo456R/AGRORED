<?php
header("Content-Type: application/json; charset=utf-8");
require_once "Conexion.php";

$metodo = $_SERVER["REQUEST_METHOD"];

try {

    
    if ($metodo === "GET") {

        if (isset($_GET["id_usuario"])) {
            $sql = "SELECT * FROM usuario WHERE id_usuario = :id";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([":id" => $_GET["id_usuario"]]);
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        } else {
            
            $sql = "SELECT u.id_usuario, u.P_nombre, u.P_apellido, u.correo, u.celular, u.rol, p.id_producto, p.nombre AS producto
                    FROM usuario u
                    LEFT JOIN productos p ON u.id_usuario = p.id_usuario";
            $consulta = $conexion->prepare($sql);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        echo json_encode($resultado);
    }

    elseif ($metodo === "POST") {

        $datos = json_decode(file_get_contents("php://input"), true);

        if (
            !is_array($datos) ||
            empty($datos["P_nombre"]) ||
            empty($datos["P_apellido"]) ||
            empty($datos["correo"]) ||
            empty($datos["contrasena"])
        ) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos obligatorios (P_nombre, P_apellido, correo, contrasena)"]);
            exit;
        }

        $sql = "INSERT INTO usuario 
                (P_nombre, S_nombre, P_apellido, S_apellido, correo, celular, contrasena, tip_documento, numero_documento, rol, direccion, departamento, municipio, codigo_postal)
                VALUES 
                (:P_nombre, :S_nombre, :P_apellido, :S_apellido, :correo, :celular, :contrasena, :tip_documento, :numero_documento, :rol, :direccion, :departamento, :municipio, :codigo_postal)";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            ":P_nombre"         => $datos["P_nombre"],
            ":S_nombre"         => $datos["S_nombre"] ?? null,
            ":P_apellido"       => $datos["P_apellido"],
            ":S_apellido"       => $datos["S_apellido"] ?? null,
            ":correo"           => $datos["correo"],
            ":celular"          => $datos["celular"] ?? null,
            ":contrasena"       => password_hash($datos["contrasena"], PASSWORD_BCRYPT), 
            ":tip_documento"    => $datos["tip_documento"] ?? null,
            ":numero_documento" => $datos["numero_documento"] ?? null,
            ":rol"              => $datos["rol"] ?? "cliente",
            ":direccion"        => $datos["direccion"] ?? null,
            ":departamento"     => $datos["departamento"] ?? null,
            ":municipio"        => $datos["municipio"] ?? null,
            ":codigo_postal"    => $datos["codigo_postal"] ?? null
        ]);

        http_response_code(201);
        echo json_encode([
            "mensaje" => "Usuario registrado correctamente",
            "id_usuario" => $conexion->lastInsertId()
        ]);
    }


    elseif ($metodo === "DELETE") {

        $id = $_GET["id_usuario"] ?? null;

        if (empty($id)) {
            http_response_code(400);
            echo json_encode(["error" => "Debe proporcionar el id_usuario"]);
            exit;
        }

        $sql = "DELETE FROM usuario WHERE id_usuario = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->execute([":id" => $id]);

        if ($consulta->rowCount() > 0) {
            echo json_encode(["mensaje" => "Usuario eliminado correctamente"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No se encontró el usuario"]);
        }
    }

    else {
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Error en la base de datos",
        "detalle" => $e->getMessage()
    ]);
}
?>
