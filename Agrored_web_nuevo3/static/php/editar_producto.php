<?php
    require 'conexion_inicial.php';

    $id = filter_input(INPUT_GET, 'id_producto', FILTER_VALIDATE_INT);
    if (!$id) { die("ID no válido"); }

    $stmt = $pdo->prepare("SELECT id_producto, id_usuario, nombre, estado_producto, descripccion,
            stock, precio FROM productos WHERE id_producto = :id_producto");
    $stmt->execute([':id_producto' => $id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) { die("Registro no encontrado"); }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto - AgroRed</title>
    <link rel="stylesheet" href="../css/agregar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="" defer></script>
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
        <h1>Registrar Producto</h1>

        <form id="form-producto" action="actualizar_productos.php" method="post">
            <input type="hidden" name="id_producto" value="<?= (int)$producto['id_producto'] ?>">

            <input type="text" id="nombre" name="nombre"  class="field" placeholder="Nombre del Producto:" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            <span class="error" id="error-nombre"></span>

            <input type="text" id="estado_producto" name="estado_producto" class="field" placeholder="Estado:" value="<?= htmlspecialchars($producto['estado_producto']) ?>"required>
            <span class="error" id="error-estado"></span>

            <textarea id="descripccion" name="descripccion" class="field" placeholder="Descripción:" required><?= htmlspecialchars($producto['descripccion']) ?></textarea>
            <span class="error" id="error-descripccion"></span>

            <input type="number" id="stock" name="stock" class="field" value="<?= (int)$producto['stock'] ?>" placeholder="Stock:" min="0" step="1" required>
            <span class="error" id="error-stock"></span>

            <input type="number" id="precio" name="precio" class="field" value="<?= (int)$producto['precio'] ?>" placeholder="Precio:" min="0" step="0.01" required>
            <span class="error" id="error-precio"></span>


            <button type="submit" class="crear">Editar</button>
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
