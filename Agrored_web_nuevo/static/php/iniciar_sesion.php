<?php

    $Servidor = "localhost";
    $Usuario = "root";
    $Contrasena_servidor = "";
    $BD = "agrored_normalizado";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $Correo = htmlspecialchars(trim($_POST['correo'] ?? ''));
        $Contrasena = htmlspecialchars(trim($_POST['contrasena'] ?? ''));

        if ($Correo === '' || $Contrasena === '') {
            exit;
        }

        $Conexion = mysqli_connect($Servidor, $Usuario, $Contrasena_servidor, $BD);

        if (!$Conexion) {
            exit;
        }

        // Consulta preparada para evitar inyección SQL
        $sql = "SELECT correo, contrasena FROM usuario WHERE correo = ? AND contrasena = ?";
        
        $stmt = mysqli_prepare($Conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $Correo, $Contrasena);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($Conexion);
        exit;
    }
?>