<?php
    $Servidor = "localhost";
    $Usuario = "root";
    $Contrasena_servidor = "";
    $BD = "agrored_normalizado";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $Nombre = htmlspecialchars($_POST['nombre']);
        $Correo = htmlspecialchars($_POST['correo']);
        $Celular = htmlspecialchars($_POST['celular']);
        $Contrasena = htmlspecialchars($_POST['contrasena']);
        $TipoDocumento = htmlspecialchars($_POST['tipo_documento']);
        $NumeroDocumento = htmlspecialchars($_POST['numero_documento']);
        $Rol = htmlspecialchars($_POST['rol']);
        $Direccion = htmlspecialchars($_POST['direccion']);
        $Departamento = htmlspecialchars($_POST['departamento']);
        $Municipio = htmlspecialchars($_POST['municipio']);
        $CodigoPostal = htmlspecialchars($_POST['codigo_postal']);

        $Conexion = mysqli_connect($Servidor, $Usuario, $Contrasena_servidor, $BD);

        $sql = "INSERT INTO usuario (nombre, correo, celular, 
        contrasena, tipo_documento, numero_documento, rol, direccion, departamento, 
        municipio, codigo_postal) VALUES('$Nombre', '$Correo', '$Celular', '$Contrasena', '$TipoDocumento', '$NumeroDocumento',
        '$Rol', '$Direccion', '$Departamento', '$Municipio', '$CodigoPostal')";


        if (mysqli_query($Conexion, $sql)){
            echo ("Daros Guardados con exito" . " ". $Nombre);
        }else{
            die("Hubo un error" . mysqi_error($Conexion));
        }
        mysqli_close($Conexion);
    }

?>