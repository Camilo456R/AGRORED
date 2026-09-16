 <?php

    header('Content-Type: application/json; charset=utf-8');

    $Servidor = "localhost";
    $Usuario = "root";
    $Contrasena_servidor = "";
    $BD = "agrored_normalizado";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $Correo = htmlspecialchars(trim($_POST['correo'] ?? ''));
        $Contrasena = htmlspecialchars(trim($_POST['contrasena'] ?? ''));

        if ($Correo === '' || $Contrasena === '') {
            echo json_encode(["success" => false, "message" => "Completa todos los campos"]);
            exit;
        }

        $Conexion = mysqli_connect($Servidor, $Usuario, $Contrasena_servidor, $BD);

        if (!$Conexion) {
            echo json_encode(["success" => false, "message" => "Error de conexión con la base de datos"]);
            exit;
        }

        // Consulta preparada para evitar inyección SQL
        $sql = "SELECT id_usuario, nombre, correo, rol FROM usuario WHERE correo = ? AND contrasena = ?";

        $stmt = mysqli_prepare($Conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $Correo, $Contrasena);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado && mysqli_num_rows($resultado) === 1) {
            $usuarioData = mysqli_fetch_assoc($resultado);

            // Inicia la sesión de PHP para que otras páginas sepan quién ingresó
            session_start();
            $_SESSION['id_usuario'] = $usuarioData['id_usuario'];
            $_SESSION['nombre'] = $usuarioData['nombre'];
            $_SESSION['rol'] = $usuarioData['rol'];

            echo json_encode([
                "success" => true,
                "message" => "Inicio de sesión exitoso",
                "usuario" => [
                    "nombre" => $usuarioData['nombre'],
                    "rol" => $usuarioData['rol']
                ]
            ]);
        } else {
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