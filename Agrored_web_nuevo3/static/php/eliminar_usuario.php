<?php

require_once "conexion_inicial.php";

if (!isset($_GET['id_usuario'])) {
    die("ID del usuario no encontrado.");
}

$id_usuario = (int) $_GET['id_usuario'];

$sql = "DELETE FROM usuario WHERE id_usuario = :id_usuario";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

try {

    $stmt->execute();

    header("Location: listado_crud.php?mensaje=Usuario eliminado correctamente");
    exit;

} catch (PDOException $e) {

    die("Error al eliminar: " . $e->getMessage());
}
?>