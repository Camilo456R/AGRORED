<?php
    $Servidor = "localhost";
    $Usuario = "root";
    $Contrasena_servidor = "";
    $BD = "agrored_normalizado_3_t";


/* 
Para declarar las variables es necesario tomar los datos del formulario con  htmlspecialchars, y pues ademas utilizar el metodo post
*/

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $Pnombre = htmlspecialchars($_POST['P_nombre']);
        $Snombre = htmlspecialchars($_POST['S_nombre']);
        $Papellido= htmlspecialchars($_POST['P_apellido']);
        $Sapellido = htmlspecialchars($_POST['S_apellido']);

        $Correo = htmlspecialchars($_POST['correo']);
        $Celular = htmlspecialchars($_POST['celular']);
        $Contrasena = $_POST['contrasena']; // Este cambia por que se cambia la contraseña para encriptar
        $TipoDocumento = htmlspecialchars($_POST['tipo_documento']);
        $NumeroDocumento = htmlspecialchars($_POST['numero_documento']);
        $Rol = htmlspecialchars($_POST['rol']);
        $Direccion = htmlspecialchars($_POST['direccion']);
        $Departamento = htmlspecialchars($_POST['departamento']);
        $Municipio = htmlspecialchars($_POST['municipio']);
        $CodigoPostal = htmlspecialchars($_POST['codigo_postal']);

        $ContrasenaHash = password_hash($Contrasena, PASSWORD_DEFAULT);// Variable especial de encriptacion

        $Conexion = mysqli_connect($Servidor, $Usuario, $Contrasena_servidor, $BD);

        

        $sql = "INSERT INTO usuario (P_nombre, S_nombre, P_apellido, S_apellido, correo, celular, contrasena, tip_documento,
                numero_documento, rol, direccion, departamento, municipio, codigo_postal)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // Los ? Hacen referencia a las variables
            /*
            
            Los signos de interrogacion permiten que no se pueda inyectar datos a la base de datos
            en caso de un hackeo o algo, pero por si solos no haran nada, por eso se declara la variable

            $stm -> Esta prepara la conexion y permite comprobar si hay errores para frenar en seco el 
            proceso
            */

        $stmt = mysqli_prepare($Conexion, $sql);

        if (!$stmt) {
            die("Hubo un error preparando la consulta: " . mysqli_error($Conexion));
        }

        mysqli_stmt_bind_param( // Este es un parametro integrado en PHP que permite isetar lso datos
            $stmt,
            "ssssssssssssss",
            $Pnombre,
            $Snombre,
            $Papellido,
            $Sapellido,
            $Correo,
            $Celular,
            $ContrasenaHash,
            $TipoDocumento,
            $NumeroDocumento,
            $Rol,
            $Direccion,
            $Departamento,
            $Municipio,
            $CodigoPostal
        );

        /* Bueno, aqui las ssssss, significan String, para que los datos entren a la tabla de esa manera 
        esto mantiene el orden pero para evitar errores se debe colocar en el orden exacto como esta en la tabla ademas de que
        debe tenerse en cuenta que por cada tipo de dato.

            s -> String
            i -> Int
            d -> float
            b -> Blop (Binario)

        */

        if (mysqli_stmt_execute($stmt)){ //Parametro de comprobacion
            echo ("Datos Guardados con exito" . " " . $Pnombre);
        }else{
            die("Hubo un error" . mysqli_error($Conexion));
        }

        mysqli_stmt_close($stmt); // Hay que serrar la conexion para evitar vulnerabilidades
        mysqli_close($Conexion);
    }

?>