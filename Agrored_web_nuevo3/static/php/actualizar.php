<?php
    require 'conexion_inicial.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { die("Método no permitido"); }

    $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $P_nombre = trim($_POST['P_nombre'] ?? '');
    $S_nombre = trim($_POST['S_nombre'] ?? '');
    $P_apellido = trim($_POST['P_apellido'] ?? '');
    $S_apellido = trim($_POST['S_apellido'] ?? '');
    $correo  = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $celular = trim($_POST['celular'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    $tip_documento = trim($_POST['tip_documento'] ?? '');
    $numero_documento = trim($_POST['numero_documento'] ?? '');
    $rol = trim($_POST['rol'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $departamento = trim($_POST['departamento'] ?? '');
    $municipio = trim($_POST['municipio'] ?? '');
    $codigo_postal = trim($_POST['codigo_postal'] ?? '');

    if (!$id_usuario || $P_nombre === '' || !$correo) {
        echo "<pre>";
        echo "id_usuario: ";  var_dump($id_usuario);
        echo "P_nombre: ";    var_dump($P_nombre);
        echo "correo: ";      var_dump($correo);
        echo "\nTodo lo que llegó por POST:\n";
        print_r($_POST);
        echo "</pre>";
        die("Datos inválidos");
}

    $contrasena = trim($_POST['contrasena'] ?? '');

    $sql = "UPDATE usuario SET
            P_nombre = :P_nombre, S_nombre = :S_nombre,
            P_apellido = :P_apellido, S_apellido = :S_apellido,
            correo = :correo, celular = :celular,
            tip_documento = :tip_documento, numero_documento = :numero_documento,
            rol = :rol, direccion = :direccion, departamento = :departamento,
            municipio = :municipio, codigo_postal = :codigo_postal";

    $params = [
        ':P_nombre' => $P_nombre, ':S_nombre' => $S_nombre,
        ':P_apellido' => $P_apellido, ':S_apellido' => $S_apellido,
        ':correo' => $correo, ':celular' => $celular,
        ':tip_documento' => $tip_documento, ':numero_documento' => $numero_documento,
        ':rol' => $rol, ':direccion' => $direccion, ':departamento' => $departamento,
        ':municipio' => $municipio, ':codigo_postal' => $codigo_postal,
        ':id_usuario' => $id_usuario,
    ];

    if ($contrasena !== '') {
        $sql .= ", contrasena = :contrasena";
        $params[':contrasena'] = password_hash($contrasena, PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id_usuario = :id_usuario";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: /Agrored_web_nuevo3/templates/iniciar_sesion.html");
    exit;
?>
