<?php
    require 'conexion_inicial.php';

    $id = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
    if (!$id) { die("ID no válido"); }

    $stmt = $pdo->prepare("SELECT id_usuario, P_nombre, S_nombre, P_apellido, S_apellido, correo, celular, contrasena, tip_documento, numero_documento, rol, direccion, departamento, municipio, codigo_postal FROM usuario WHERE id_usuario = :id_usuario");
    $stmt->execute([':id_usuario' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) { die("Registro no encontrado"); }
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroRed | Editar usuario</title>
    <link rel="icon" href="../img/Logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/registrarse.css">
    <!--<script src="../js/actions_registrarse.js"></script>
    <link rel="icon" href="../img/Logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->


</head>
<body>

    <!--Navbar-->
    <nav>
        <div class="Navbar">
            <a href="../templates/index.html" class="logo-link">
                <img src="../img/Logo_letras.png" alt="" width="30%" class="imagen_logo">
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


    <div class="register-container">

        <div class="register-image">
            <img src="https://images.pexels.com/photos/1267325/pexels-photo-1267325.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="Campo">
            <div class="image-overlay">
                <h2>Cosechamos<br>Oportunidades<br>Para Todos.</h2>
            </div>
        </div>

        <div class="register-form-section">
            <div class="logo-reg">
                <img src="../img/Logo.png" height="30">
                <div>AGRO<span>RED</span></div>
            </div>

            <h3>Editar registro</h3>
            <p class="subtitle">Actualiza tus datos aquí.</p>
            

            <form action="actualizar.php" method="post">
                <input type="hidden" name="id_usuario" value="<?= (int)$usuario['id_usuario'] ?>">
                <div class="input-group full-width">
                    <label>Primer Nombre</label>
                    <input type="text" name="P_nombre" id="P_nombre" value="<?= htmlspecialchars($usuario['P_nombre']) ?>" placeholder="Escribe tu primer nombre" required>
                </div>

                <div class="input-group full-width">
                    <label>Segundo Nombre</label>
                    <input type="text" name="S_nombre" id="S_nombre" value="<?= htmlspecialchars($usuario['S_nombre']) ?>" placeholder="Escribe tu Segundo nombre" required>
                </div>

                <div class="input-group full-width">
                    <label>Primer apellido</label>
                    <input type="text" name="P_apellido" id="P_apellido" value="<?= htmlspecialchars($usuario['P_apellido']) ?>" placeholder="Escribe tu Primer apellido" required>
                </div>

                <div class="input-group full-width">
                    <label>Segundo apellido</label>
                    <input type="text" name="S_apellido" id="S_apellido" value="<?= htmlspecialchars($usuario['S_apellido']) ?>" placeholder="Escribe tu Segundo apellido" required>
                </div>


                <div class="input-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="input-group">
                    <label>Número de Celular</label>
                    <input type="tel" name="celular" id="celular" value="<?= htmlspecialchars($usuario['celular']) ?>" placeholder="300 000 0000" required>
                </div>

                <div class="input-group full-width password-wrapper">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" placeholder="Déjalo vacío para no cambiarla" minlength="8">                    <span class="material-icons-round toggle-password">visibility</span>
                </div>

                <div class="input-group">
                    <label>Tipo de Documento</label>
                    <select name="tip_documento">
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="NIT">NIT (Empresas)</option>
                        <option value="CE">Cédula de Extranjería</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Número de Documento</label>
                    <input type="text" name="numero_documento" id="numeroDocumento" value="<?= htmlspecialchars($usuario['numero_documento']) ?>" placeholder="123456789" required>
                </div>

                <div class="input-group full-width">
                    <label>¿Cuál es tu rol en AgroRed?</label>
                    <select name="rol" id="rol" required>
                        <option value="comprador" <?= $usuario['rol'] === 'comprador' ? 'selected' : '' ?>>Quiero comprar (Cliente)</option>
                        <option value="vendedor"  <?= $usuario['rol'] === 'vendedor'  ? 'selected' : '' ?>>Quiero vender (Productor/Campesino)</option>
                    </select>
                </div>

                <div class="input-group full-width">
                    <label>Dirección de residencia o entrega</label>
                    <input type="text" name="direccion" id="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>" placeholder="Calle, Carrera, número..." required>
                </div>

                <div class="input-group">
                    <label>Departamento</label>
                    <!--Departamentos-->
                    <select name="departamento" id="departamento">
                        <option value="<?= htmlspecialchars($usuario['departamento']) ?>"><?= htmlspecialchars($usuario['departamento']) ?></option>
                        <option value="Amazonas">Amazonas</option>
                        <option value="Antioquia">Antioquia</option>
                        <option value="Arauca">Arauca</option>
                        <option value="Atlántico">Atlántico</option>
                        <option value="Bogotá D.C.">Bogotá D.C.</option>
                        <option value="Bolívar">Bolívar</option>
                        <option value="Boyacá">Boyacá</option>
                        <option value="Caldas">Caldas</option>
                        <option value="Caquetá">Caquetá</option>
                        <option value="Casanare">Casanare</option>
                        <option value="Cauca">Cauca</option>
                        <option value="Cesar">Cesar</option>
                        <option value="Chocó">Chocó</option>
                        <option value="Córdoba">Córdoba</option>
                        <option value="Cundinamarca">Cundinamarca</option>
                        <option value="Guainía">Guainía</option>
                        <option value="Guaviare">Guaviare</option>
                        <option value="Huila">Huila</option>
                        <option value="La Guajira">La Guajira</option>
                        <option value="Magdalena">Magdalena</option>
                        <option value="Meta">Meta</option>
                        <option value="Nariño">Nariño</option>
                        <option value="Norte de Santander">Norte de Santander</option>
                        <option value="Putumayo">Putumayo</option>
                        <option value="Quindío">Quindío</option>
                        <option value="Risaralda">Risaralda</option>
                        <option value="San Andrés y Providencia">San Andrés y Providencia</option>
                        <option value="Santander">Santander</option>
                        <option value="Sucre">Sucre</option>
                        <option value="Tolima">Tolima</option>
                        <option value="Valle del Cauca">Valle del Cauca</option>
                        <option value="Vaupés">Vaupés</option>
                        <option value="Vichada">Vichada</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Municipio</label>
                    <input type="text" name="municipio" id="municipio" value="<?= htmlspecialchars($usuario['municipio']) ?>" placeholder="Ciudad o Municipio">
                </div>

                <div class="input-group full-width">
                    <label>Código Postal</label>
                    <input type="text" name="codigo_postal" value="<?= htmlspecialchars($usuario['codigo_postal']) ?>" placeholder="Opcional">
                </div>

                <button type="submit" class="btn-register">
                    Editar registro
                </button>

            </form>
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
