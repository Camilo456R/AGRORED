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

      elseif ($metodo === "PUT") {

        $datos = json_decode(file_get_contents("php://input"), true);

        if (!is_array($datos) || empty($datos["id_usuario"])) {
            http_response_code(400);
            echo json_encode([
                "error" => "Debe proporcionar el id_usuario para actualizar"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

       
        $verificar = $conexion->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
        $verificar->execute([":id" => $datos["id_usuario"]]);
        $usuarioActual = $verificar->fetch(PDO::FETCH_ASSOC);

        if (!$usuarioActual) {
            http_response_code(404);
            echo json_encode([
                "error" => "El id_usuario no existe en la base de datos"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

     
        $contrasenaFinal = !empty($datos["contrasena"]) 
            ? password_hash($datos["contrasena"], PASSWORD_BCRYPT) 
            : $usuarioActual["contrasena"];

     
        $sql = "UPDATE usuario SET 
                    P_nombre = :P_nombre,
                    S_nombre = :S_nombre,
                    P_apellido = :P_apellido,
                    S_apellido = :S_apellido,
                    correo = :correo,
                    celular = :celular,
                    contrasena = :contrasena,
                    tip_documento = :tip_documento,
                    numero_documento = :numero_documento,
                    rol = :rol,
                    direccion = :direccion,
                    departamento = :departamento,
                    municipio = :municipio,
                    codigo_postal = :codigo_postal
                WHERE id_usuario = :id_usuario";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([
            ":id_usuario"       => $datos["id_usuario"],
            ":P_nombre"         => $datos["P_nombre"] ?? $usuarioActual["P_nombre"],
            ":S_nombre"         => array_key_exists("S_nombre", $datos) ? $datos["S_nombre"] : $usuarioActual["S_nombre"],
            ":P_apellido"       => $datos["P_apellido"] ?? $usuarioActual["P_apellido"],
            ":S_apellido"       => array_key_exists("S_apellido", $datos) ? $datos["S_apellido"] : $usuarioActual["S_apellido"],
            ":correo"           => $datos["correo"] ?? $usuarioActual["correo"],
            ":celular"          => array_key_exists("celular", $datos) ? $datos["celular"] : $usuarioActual["celular"],
            ":contrasena"       => $contrasenaFinal,
            ":tip_documento"    => array_key_exists("tip_documento", $datos) ? $datos["tip_documento"] : $usuarioActual["tip_documento"],
            ":numero_documento" => array_key_exists("numero_documento", $datos) ? $datos["numero_documento"] : $usuarioActual["numero_documento"],
            ":rol"              => $datos["rol"] ?? $usuarioActual["rol"],
            ":direccion"        => array_key_exists("direccion", $datos) ? $datos["direccion"] : $usuarioActual["direccion"],
            ":departamento"     => array_key_exists("departamento", $datos) ? $datos["departamento"] : $usuarioActual["departamento"],
            ":municipio"        => array_key_exists("municipio", $datos) ? $datos["municipio"] : $usuarioActual["municipio"],
            ":codigo_postal"    => array_key_exists("codigo_postal", $datos) ? $datos["codigo_postal"] : $usuarioActual["codigo_postal"]
        ]);

        if ($consulta->rowCount() > 0) {
            echo json_encode([
                "mensaje" => "Usuario actualizado correctamente"
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                "mensaje" => "El usuario existe, pero no hubo cambios porque los datos son iguales."
            ], JSON_UNESCAPED_UNICODE);
        }
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
