<?php
    $Servidor = "localhost";
    $Usuario = "root";
    $Contrasena_servidor = "";
    $BD = "agrored_normalizado_3_t";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $Nombre         = htmlspecialchars($_POST['nombre']);
        $EstadoProducto = htmlspecialchars($_POST['estado_producto']);
        $Descripcion    = htmlspecialchars($_POST['descripcion']);
        $Stock          = (int) $_POST['stock'];     // número entero
        $Precio         = (float) $_POST['precio'];  // número decimal


        $IdUsuario = 1;

        $Conexion = mysqli_connect($Servidor, $Usuario, $Contrasena_servidor, $BD);

        if (!$Conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO productos (id_usuario, nombre, estado_producto, descripccion, stock, precio)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($Conexion, $sql);

        if (!$stmt) {
            die("Hubo un error preparando la consulta: " . mysqli_error($Conexion));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "isssid",
            $IdUsuario,
            $Nombre,
            $EstadoProducto,
            $Descripcion,
            $Stock,
            $Precio
        );

        if (mysqli_stmt_execute($stmt)) {
            echo "Datos guardados con éxito " . $Nombre;
        } else {
            die("Hubo un error: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        mysqli_close($Conexion);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exito al registrar</title>
</head>
<body>
    <a href="listado_productos.php">Volver</a>
</body>
</html>