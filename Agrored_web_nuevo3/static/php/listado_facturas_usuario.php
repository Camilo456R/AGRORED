<?php
require_once "conexion_inicial.php";

/*
 * Relación entre tablas:
 *   factura.id_pedido  -> pedido.id_pedido
 *   pedido.id_usuario  -> usuario.id_usuario
 *   factura.id_pago    -> pago.id_pago
 */
// Filtro opcional: listado_facturas_usuario.php?id_usuario=3
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);

$sql = "SELECT f.id_factura,
               f.fecha_emision,
               u.id_usuario,
               u.P_nombre, u.S_nombre, u.P_apellido, u.S_apellido,
               u.correo,
               p.id_pedido,
               p.estado       AS estado_pedido,
               pg.metodo_pago,
               pg.monto,
               pg.estado      AS estado_pago
        FROM factura f
        INNER JOIN pedido  p  ON f.id_pedido  = p.id_pedido
        INNER JOIN usuario u  ON p.id_usuario = u.id_usuario
        INNER JOIN pago    pg ON f.id_pago    = pg.id_pago";

$params = [];
if ($id_usuario) {
    $sql .= " WHERE u.id_usuario = :id_usuario";
    $params[':id_usuario'] = $id_usuario;
}

$sql .= " ORDER BY f.id_factura ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nombre y apellido del usuario para el título cuando se filtra.
// Se consulta aparte para que el título salga aunque el usuario no tenga facturas.
$nombre   = '';
$apellido = '';
if ($id_usuario) {
    $stmtU = $pdo->prepare("SELECT P_nombre, S_nombre, P_apellido, S_apellido
                            FROM usuario WHERE id_usuario = :id_usuario");
    $stmtU->execute([':id_usuario' => $id_usuario]);
    $u = $stmtU->fetch(PDO::FETCH_ASSOC);
    if ($u) {
        $nombre   = trim(($u['P_nombre']   ?? '') . ' ' . ($u['S_nombre']   ?? ''));
        $apellido = trim(($u['P_apellido'] ?? '') . ' ' . ($u['S_apellido'] ?? ''));
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Facturas por usuario</title>
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

    <h1>
        <?= $nombre !== ''
            ? 'Facturas de ' . htmlspecialchars($nombre . ' ' . $apellido)
            : 'Facturas por usuario' ?>
    </h1>

    <?php if ($id_usuario): ?>
        <p>
            <a href="listado_facturas_usuario.php">Ver todas las facturas</a> |
            <a href="listado_crud.php">Volver al listado de clientes</a>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="mensaje">
            <?= htmlspecialchars($_GET['mensaje']) ?>
        </div>
    <?php endif; ?>

    <div class="tabla-scroll">

        <table>

            <thead>
                <tr>
                    <th>N.º factura</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>N.º pedido</th>
                    <th>Estado pedido</th>
                    <th>Método de pago</th>
                    <th>Monto</th>
                    <th>Estado pago</th>
                    <th>Fecha emisión</th>
                    <th class="acciones">ACCIONES</th>
                </tr>
            </thead>

            <tbody>

            <?php if (count($facturas) > 0): ?>

                <?php foreach ($facturas as $f): ?>

                    <?php
                        // Nombre = primer + segundo nombre; Apellido = primer + segundo apellido
                        // (ignora el segundo si está vacío)
                        $nombre   = trim(($f['P_nombre']   ?? '') . ' ' . ($f['S_nombre']   ?? ''));
                        $apellido = trim(($f['P_apellido'] ?? '') . ' ' . ($f['S_apellido'] ?? ''));
                    ?>

                    <tr>
                        <td><?= (int)$f['id_factura'] ?></td>
                        <td><?= htmlspecialchars($nombre) ?></td>
                        <td><?= htmlspecialchars($apellido) ?></td>
                        <td><?= htmlspecialchars($f['correo'] ?? '') ?></td>
                        <td><?= (int)$f['id_pedido'] ?></td>
                        <td><?= htmlspecialchars($f['estado_pedido'] ?? '') ?></td>
                        <td><?= htmlspecialchars($f['metodo_pago'] ?? '') ?></td>
                        <td>$<?= number_format((int)$f['monto'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($f['estado_pago'] ?? '') ?></td>
                        <td><?= htmlspecialchars($f['fecha_emision'] ?? '') ?></td>

                        <td class="acciones">
                            <a
                                class="btn-editar"
                                href="editar_factura.php?id_factura=<?= (int)$f['id_factura'] ?>"
                            >
                                EDITAR
                            </a>

                            <a
                                class="btn-eliminar"
                                href="eliminar_factura.php?id_factura=<?= (int)$f['id_factura'] ?>"
                                onclick="return confirm('¿Está seguro de eliminar esta factura?');"
                            >
                                ELIMINAR
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="11">No existen registros.</td>
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