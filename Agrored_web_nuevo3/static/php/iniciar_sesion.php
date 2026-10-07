<?php
    session_start(); // Primero se busca inicar sesion

    header('Content-Type: application/json; charset=utf-8'); // Permite el lenguage español

    $Servidor = "localhost";
    $Usuario = "root";
    $Contrasena_servidor = "";
    $BD = "agrored_normalizado_3_t";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $Correo = trim($_POST['correo'] ?? '');
        $Contrasena = $_POST['contrasena'] ?? '';

        if ($Correo === '' || $Contrasena === '') {
            echo json_encode(["success" => false, "message" => "Completa todos los campos"]);
            exit;
        }

        $Conexion = mysqli_connect($Servidor, $Usuario, $Contrasena_servidor, $BD);

        if (!$Conexion) {
            echo json_encode(["success" => false, "message" => "Error de conexión con la base de datos"]);
            exit;
        }

        $sql = "SELECT id_usuario, P_nombre, correo, rol, contrasena FROM usuario WHERE correo = ?";
        
        $stmt = mysqli_prepare($Conexion, $sql);
        mysqli_stmt_bind_param($stmt, "s", $Correo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $usuarioData = $resultado ? mysqli_fetch_assoc($resultado) : null;

        // password_verify hace la comparacion segura contra el hash guardado
        if ($usuarioData && password_verify($Contrasena, $usuarioData['contrasena'])) {

            $_SESSION['id_usuario'] = $usuarioData['id_usuario'];
            $_SESSION['nombre']     = $usuarioData['P_nombre'];
            $_SESSION['rol']        = $usuarioData['rol'];

            echo json_encode([
                "success" => true,
                "message" => "Inicio de sesión exitoso",
                "usuario" => [
                    "nombre" => $usuarioData['P_nombre'],
                    "rol"    => $usuarioData['rol']
                ]
            ]);

        } else {
            // Mismo mensaje tanto si el correo no existe como si la contrasena esta mal,
            // asi no le decimos a un atacante cual de los dos fallo.
            echo json_encode(["success" => false, "message" => "Correo o contraseña incorrectos"]);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($Conexion);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Método no permitido"]);
        exit;
    }
?>