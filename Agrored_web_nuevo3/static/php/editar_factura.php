<?php
    require 'conexion_inicial.php';

    $id = filter_input(INPUT_GET, 'id_factura', FILTER_VALIDATE_INT);
    if (!$id) { die("ID no válido"); }

    $stmt = $pdo->prepare("SELECT id_factura, id_pedido, id_pago, fecha_emision
            FROM factura WHERE id_factura = :id_factura");

    $stmt->execute([':id_factura' => $id]);
    $factura = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$factura) { die("Registro no encontrado"); }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar factura - AgroRed</title>
    <link rel="stylesheet" href="../css/agregar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../static/img/Logo.png">
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="Navbar">
        <a href="../../templates/index.html" class="logo-link">
            <img src="../../static/img/Logo_letras.png" alt="AgroRed" width="30%" class="imagen_logo">
        </a>
        <a href="../../templates/productos.html">Productos</a>
        <a href="../../templates/noticias.html">Noticias</a>
        <a href="../../templates/mejoras.html">Mejoras</a>
        <input type="search" placeholder="Buscar...">

        <div class="botones">
            <a href="../../templates/iniciar_sesion.html"><input type="button" value="Iniciar" class="Iniciar"></a>
            <a href="../../templates/registrarse.html"><input type="button" value="Registrarse" class="Registrarse"></a>
        </div>
    </div>
</nav>

<!-- Formulario -->
<div class="form-wrapper">
    <div class="card">
        <img src="../../static/img/Logo_letras.png" alt="AgroRed" class="logo" width="50%">
        <h1>Editar factura</h1>

        <form id="form-producto" action="actualizar_facturas.php" method="post">
            <input type="hidden" name="id_factura" value="<?= (int)$factura['id_factura'] ?>">

            <label for="fecha_emision">Fecha de emisión</label>
            <input type="date"
                id="fecha_emision"
                name="fecha_emision"
                class="field"
                value="<?= htmlspecialchars($factura['fecha_emision']) ?>"
                max="<?= date('Y-m-d') ?>"
                required>
            <span class="error" id="error-fecha"></span>
            <button type="submit" class="crear">Guardar</button>
        </form>
    </div>
</div>

<!-- Footer -->
<footer class="pie-pagina">
    <div class="contenedor-footer">

        <div class="columna-footer">
            <div class="logo">AGRO<span class="red">RED</span></div>
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

</body>
</html>
