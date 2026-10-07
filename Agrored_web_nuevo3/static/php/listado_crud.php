<?php
require_once "conexion_inicial.php";

// Se excluye la contraseña a propósito: nunca debe mostrarse en un listado
$sql = "SELECT id_usuario, P_nombre, S_nombre, P_apellido, S_apellido,
            correo, celular, tip_documento, numero_documento,
            rol, direccion, departamento, municipio, codigo_postal
        FROM usuario
        ORDER BY id_usuario DESC";

$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        .contenedor {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background: #333;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8f8f8;
        }

        .btn {
            display: inline-block;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
        }


        .editar {
            background: #007bff;
        }

        .editar:hover {
            background: #0056b3;
        }

        .mensaje {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    
    </style>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../static/img/Logo.png">
</head>
<!--Navbar-->
    <nav>
        <div class="Navbar">
            <a href="../templates/index.html" class="logo-link">
                <img src="../static/img/Logo_letras.png" alt="" width="30%" class="imagen_logo">
            </a>
            <a href="../templates/productos.html">Productos</a>
            <a href="../templates/noticias.html">Noticias</a>
            <a href="../templates/mejoras.html">Mejoras</a>
            <input type="search" placeholder="Arroz">

            <div class="botones">
                <a href="../templates/iniciar_sesion.html"><input type="button" value="Iniciar" class="Iniciar"></a>
                <a href="../templates/registrarse.html"><input type="button" value="Registrarse" class="Registrarse"></a>
            </div>
        </div>
    </nav>
<!--Fin Navbar-->





<body>
    <div class="contenedor">

        <h1>Listado de clientes</h1>

        <?php if (isset($_GET['mensaje'])): ?>

            <div class="mensaje">
                <?= htmlspecialchars($_GET['mensaje']) ?>
            </div>

        <?php endif; ?>

        <div class="tabla-scroll">
        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Primer nombre</th>
                    <th>Segundo nombre</th>
                    <th>Primer apellido</th>
                    <th>Segundo apellido</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Tipo doc.</th>
                    <th>N.º documento</th>
                    <th>Rol</th>
                    <th>Dirección</th>
                    <th>Departamento</th>
                    <th>Municipio</th>
                    <th>Código postal</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            <?php if (count($usuarios) > 0): ?>

                <?php foreach ($usuarios as $usuario): ?>

                    <tr>
                        <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                        <td><?= htmlspecialchars($usuario['P_nombre'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['S_nombre'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['P_apellido'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['S_apellido'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['correo'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['celular'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['tip_documento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['numero_documento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['rol'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['direccion'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['departamento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['municipio'] ?? '') ?></td>
                        <td><?= htmlspecialchars($usuario['codigo_postal'] ?? '') ?></td>

                        <td>
                            <a
                                class="btn editar"
                                href="editar_usuario.php?id_usuario=<?= (int) $usuario['id_usuario'] ?>"
                            >
                                Editar
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="15">
                        No existen registros.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>
        </div>

    </div>


        <!--Footer-->

    <footer class="pie-pagina">
        <div class="contenedor-footer">
            
            <div class="columna-footer">
                <h3>AGRORED</h3>
                <p>Conectando el campo con tu mesa. Llena el formulario y empieza a vender o comprar productos frescos de la mejor calidad.</p>
            </div>

            <div class="columna-footer">
                <h4>Navegación</h4>
                <ul>
                    <li><a href="#">Productos</a></li>
                    <li><a href="#">Noticias</a></li>
                    <li><a href="#">Mejoras</a></li>
                    <li><a href="#">Categorías</a></li>
                </ul>
            </div>

            <div class="columna-footer">
                <h4>Soporte</h4>
                <ul>
                    <li><a href="#">Preguntas Frecuentes</a></li>
                    <li><a href="#">Términos y Condiciones</a></li>
                    <li><a href="#">Política de Privacidad</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>

        </div>

        <div class="copyright-footer">
            <p>&copy; 2026 AGRORED. Todos los derechos reservados.</p>
        </div>
    </footer>
    <!--Fin Footer-->


</body>
</html>