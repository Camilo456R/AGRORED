<?php
    // Si vas a probar el front-end con Live Server (puerto 5500) mientras el PHP
    // corre en Apache/XAMPP (puerto 80), descomenta esta linea para permitir la
    // peticion entre distintos origenes. Si todo corre desde XAMPP no la necesitas.
    // header("Access-Control-Allow-Origin: http://127.0.0.1:5500");

    header('Content-Type: application/json; charset=utf-8');

    $servidor = "localhost";
    $usuario_db = "root";
    $clave_db = "";
    $db = "tablas_1"; // Nombre de la base de datos según tu archivo tablas_1.sql

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Recibir y limpiar los datos de forma básica
        $nombreCompleto   = htmlspecialchars($_POST['nombre']);
        $email            = htmlspecialchars($_POST['email']);
        $telefono         = htmlspecialchars($_POST['telefono']);
        $contrasena       = $_POST['contrasena']; // se hashea antes de guardarse, no se limpia con htmlspecialchars
        $tipoDocumento    = htmlspecialchars($_POST['tipo_documento']);
        $numeroDocumento  = htmlspecialchars($_POST['numero_documento']);
        $rol              = htmlspecialchars($_POST['rol']);
        $nombreFinca      = htmlspecialchars($_POST['nombre_finca'] ?? '');
        $direccion        = htmlspecialchars($_POST['direccion']);
        $departamento     = htmlspecialchars($_POST['departamento']);
        $municipio        = htmlspecialchars($_POST['municipio']);
        $codigoPostal     = htmlspecialchars($_POST['codigo_postal'] ?? '');

        // La tabla `usuario` guarda nombre y apellido por separado,
        // pero el formulario solo pide "Nombre Completo", así que lo dividimos.
        $partesNombre = explode(' ', trim($nombreCompleto), 2);
        $nombre   = $partesNombre[0];
        $apellido = $partesNombre[1] ?? '';

        // id_usuario es varchar(15) y no es autoincremental, así que generamos uno único
        $idUsuario = 'U' . substr(md5(uniqid((string) mt_rand(), true)), 0, 10);

        // Nunca se guarda la contraseña en texto plano
        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

        $miconexion = mysqli_connect($servidor, $usuario_db, $clave_db, $db, 3306);

        if (!$miconexion) {
            echo json_encode(["exito" => false, "mensaje" => "Conexión No Aprobada"]);
            exit;
        }

        $sql = "INSERT INTO usuario
                    (id_usuario, nombre, apellido, correo, direccion, telefono, rol,
                     contrasena, tipo_documento, numero_documento, nombre_finca,
                     departamento, municipio, codigo_postal)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($miconexion, $sql);

        if (!$stmt) {
            echo json_encode(["exito" => false, "mensaje" => "Error al preparar la consulta: " . mysqli_error($miconexion)]);
            exit;
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssss",
            $idUsuario,
            $nombre,
            $apellido,
            $email,
            $direccion,
            $telefono,
            $rol,
            $contrasenaHash,
            $tipoDocumento,
            $numeroDocumento,
            $nombreFinca,
            $departamento,
            $municipio,
            $codigoPostal
        );

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["exito" => true, "mensaje" => "Nuevo Registro Creado Satisfactoriamente"]);
        } else {
            echo json_encode(["exito" => false, "mensaje" => "Error: " . mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($miconexion);
    } else {
        echo json_encode(["exito" => false, "mensaje" => "Método no permitido"]);
    }
?>
