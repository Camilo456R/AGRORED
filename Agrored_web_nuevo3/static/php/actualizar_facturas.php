<?php
require 'conexion_inicial.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { die("Método no permitido"); }

$id_factura    = filter_input(INPUT_POST, 'id_factura', FILTER_VALIDATE_INT);
$fecha_emision = trim($_POST['fecha_emision'] ?? '');

if (!$id_factura || $fecha_emision === '') {
    die("Datos inválidos");
}

$stmt = $pdo->prepare("UPDATE factura SET fecha_emision = :fecha_emision 
        WHERE id_factura = :id_factura");
        
$stmt->execute([
    ':fecha_emision' => $fecha_emision,
    ':id_factura'    => $id_factura,
]);

header("Location: /Agrored_web_nuevo3/static/php/listado_facturas.php");
exit;