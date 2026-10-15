<?php

require_once "conexion_inicial.php";

if (!isset($_GET['id_factura'])) {
    die("ID del usuario no encontrado.");
}

$id_factura = (int) $_GET['id_factura'];

$sql = "DELETE FROM factura WHERE id_factura = :id_factura";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_factura', $id_factura, PDO::PARAM_INT);

try {

    $stmt->execute();

    header("Location: listado_facturas.php?mensaje=factura eliminada correctamente");
    exit;

} catch (PDOException $e) {

    die("Error al eliminar: " . $e->getMessage());
}
?>
