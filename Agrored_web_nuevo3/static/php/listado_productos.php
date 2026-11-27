<?php
require_once "conexion_inicial.php";

$sql = "SELECT id_producto, id_usuario, nombre, estado_producto, descripccion,
        stock, precio FROM productos ORDER BY id_producto ASC";

						



$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo.png">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .contenedor {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .tabla-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #333;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8f8f8;
        }

        .acciones {
            min-width: 170px;
            text-align: center;
        }

        .btn-editar {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }

        .btn-eliminar {
            display: inline-block;
            background: red;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .mensaje {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<!--Navbar-->
    <nav>
        <div class="Navbar">
            <a href="../../templates/index.html" class="logo-link">
                <img src="../img/Logo_letras.png" alt="" width="30%" class="imagen_logo">
            </a>
            <a href="../../templates/productos.html">Productos</a>
            <a href="../../templates/noticias.html">Noticias</a>
            <a href="../../templates/mejoras.html">Mejoras</a>
            <input type="search" placeholder="Arroz">

            <div class="botones">
                <a href="../../templates/iniciar_sesion.html"><input type="button" value="Iniciar" class="Iniciar"></a>
                <a href="../../templates/registrarse.html"><input type="button" value="Registrarse" class="Registrarse"></a>
            </div>
        </div>
    </nav>
<!--Fin Navbar-->



<div class="contenedor">

    <h1>Listado de Productos</h1>

    <?php if (isset($_GET['mensaje'])): ?>

        <div class="mensaje">
            <?= htmlspecialchars($_GET['mensaje']) ?>
        </div>

    <?php endif; ?>

    <a href="../../templates/registrar_productos.html">Registrar uno nuevo</a>
    <div class="tabla-scroll">

        <table>

            <thead>
						
                <tr>
                    <th>id_producto</th>
                    <th>id_usuario</th>
                    <th>nombre</th>
                    <th>estado_producto</th>
                    <th>descripcion</th>
                    <th>stock</th>
                    <th>precio</th>
                    <th class="acciones">ACCIONES</th>
                </tr>

            </thead>


            <tbody>

            <?php if (count($productos) > 0): ?>

                <?php foreach ($productos as $producto): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($producto['id_producto']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($producto['id_usuario'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($producto['nombre'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($producto['estado_producto'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($producto['descripccion'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($producto['stock'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($producto['precio'] ?? '') ?>
                        </td>

                    
                        <td class="acciones">

                            <a
                                class="btn-editar"
                                href="editar_producto.php?id_producto=<?= (int)$producto['id_producto'] ?>"
                            >
                                EDITAR
                            </a>

                            <a
                                class="btn-eliminar"
                                href="eliminar_producto.php?id_producto=<?= (int)$producto['id_producto'] ?>"
                                onclick="return confirm('¿Está seguro de eliminar este producto?');"
                            >
                                ELIMINAR
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>


            <?php else: ?>

                <tr>
                    <td colspan="8">
                        No existen registros.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>
<br>
<hr>
<a href="../../templates/menu_admin.html">Volver al menu</a>


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