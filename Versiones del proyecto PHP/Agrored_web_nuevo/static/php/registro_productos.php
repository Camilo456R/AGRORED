<?php
$Servidor = "localhost";
$Usuario = "root";
$Contrasena_servidor = "";
$BD = "agrored_normalizado";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre = htmlspecialchars($_POST['nombre']);
    $Estado = htmlspecialchars($_POST['estado']);
    $Descripcion = htmlspecialchars($_POST['descripcion']);
    $Stock = htmlspecialchars($_POST['stock']);
    $Precio = htmlspecialchars($_POST['precio']);

    // Vendedor fijo temporal (sin sistema de login todavía)
    $IdVendedor = 1;

    $Conexion = mysqli_connect($Servidor, $Usuario, $Contrasena_servidor, $BD);

    if (!$Conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $stmt = $Conexion->prepare(
        "INSERT INTO productos (nombre, estado_producto, descripcion, stock, precio, id_vendedor, id_comprador)
        VALUES (?, ?, ?, ?, ?, ?, NULL)"
    );
    $stmt->bind_param("sssdii", $Nombre, $Estado, $Descripcion, $Stock, $Precio, $IdVendedor);

    if ($stmt->execute()) {
        echo "Datos guardados con éxito " . $Nombre;
    } else {
        die("Hubo un error: " . $stmt->error);
    }

    $stmt->close();
    mysqli_close($Conexion);
}
?>