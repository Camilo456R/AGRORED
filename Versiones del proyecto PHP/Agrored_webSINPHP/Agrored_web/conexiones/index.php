<?php
require 'Conexion.php';

// Ahora puedes usar la variable $conexion


$query = $conexion->query("SELECT * FROM usuarios");
while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
    echo $fila['Nombre'] . "<br>";
}
// PDO::FETCH_ASSOC se usa en PHP para recuperar las filas 
// de una base de datos como un array asociativo donde las claves
// son los nombres de las columnas de la tabla
//Devuelve un arreglo (array) donde cada columna de la base de datos
//se identifica por su nombre en lugar de un número.
?>
