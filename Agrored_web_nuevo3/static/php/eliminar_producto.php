<?php

require_once "conexion_inicial.php";

if (!isset($_GET['id_producto'])) {
    die("ID del usuario no encontrado.");
}

$id_producto = (int) $_GET['id_producto'];

$sql = "DELETE FROM productos WHERE id_producto = :id_producto";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);

try {

    $stmt->execute();

    header("Location: listado_productos.php?mensaje=Usuario eliminado correctamente");
    exit;

} catch (PDOException $e) {

    die("Error al eliminar: " . $e->getMessage());
}
?>
