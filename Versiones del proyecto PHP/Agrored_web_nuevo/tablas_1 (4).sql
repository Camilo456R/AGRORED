-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2026 a las 16:03:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS `agrored_normalizado` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `agrored_normalizado`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tablas_1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_administrador` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `id_calificacion` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_comprador` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `puntuacion` tinyint(4) NOT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `estado` enum('activo','abandonado','procesado') NOT NULL DEFAULT 'activo',
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `tipo` enum('fruta','verdura') NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id_chat` int(11) NOT NULL,
  `id_comprador` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `estado` enum('activo','en_curso','finalizado') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprador`
--

CREATE TABLE `comprador` (
  `id_comprador` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_carrito`
--

CREATE TABLE `detalle_carrito` (
  `id_detalle` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_productos` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_productos` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `fecha_emision` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_estado_pedido`
--

CREATE TABLE `historial_estado_pedido` (
  `id_historial` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `fecha_cambio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id_mensaje` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'Remitente del mensaje',
  `contenido` text NOT NULL,
  `fecha_envio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_inventario`
--

CREATE TABLE `movimiento_inventario` (
  `id_movimiento` int(11) NOT NULL,
  `id_productos` int(11) NOT NULL,
  `tipo_movimiento` enum('entrada','salida','ajuste') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_movimiento` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `contenido` varchar(100) NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `metodo_pago` varchar(30) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_pago` datetime NOT NULL,
  `estado` enum('aprobado','pendiente','rechazado') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'Comprador que realiza el pedido',
  `fecha_pedido` datetime NOT NULL,
  `estado` enum('pendiente','enviado','entregado','completado','cancelado') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_productos` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado_producto` varchar(15) DEFAULT NULL COMMENT 'nuevo, usado, activo, etc.',
  `descripcion` varchar(200) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `precio` decimal(10,2) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_comprador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_productos`, `nombre`, `estado_producto`, `descripcion`, `stock`, `precio`, `id_vendedor`, `id_comprador`) VALUES
(1, 'Pera', '', '', 0, 0.00, 1, NULL),
(3, 'Manzana', 'Cualquiera', 'MAnzana', 1, 0.00, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_categoria`
--

CREATE TABLE `producto_categoria` (
  `id_productos` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` int(11) NOT NULL,
  `id_productos` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario que hace el reporte',
  `tipo_reporte` varchar(20) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte_tecnico`
--

CREATE TABLE `soporte_tecnico` (
  `id_soporte` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'Usuario que solicita el soporte',
  `id_administrador` int(11) DEFAULT NULL,
  `asunto` varchar(50) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `estado` enum('abierto','en_proceso','cerrado') NOT NULL DEFAULT 'abierto',
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL COMMENT 'Guardada con hash, nunca en texto plano',
  `tipo_documento` varchar(10) DEFAULT NULL,
  `numero_documento` varchar(25) DEFAULT NULL,
  `rol` enum('administrador','vendedor','comprador') DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `departamento` varchar(50) DEFAULT NULL,
  `municipio` varchar(50) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `celular`, `contrasena`, `tipo_documento`, `numero_documento`, `rol`, `direccion`, `departamento`, `municipio`, `codigo_postal`) VALUES
(1, 'Camilo', 'Camilo@asd', '123159753456852', 'Camilo_456_R', 'CC', '159753456', 'comprador', '159753285', 'Amazonas', 'Leticia', '11141'),
(2, 'Camilo 2', 'Camilo2@asd', '159753456', 'Camilo486', 'CC', '123456789', 'vendedor', 'Cualquiera', 'Bogotá D.C.', 'Suba', '111141');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `id_vendedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL COMMENT 'Resena del tipo de productos que vende',
  `ubicacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`id_vendedor`, `id_usuario`, `descripcion`, `ubicacion`) VALUES
(1, 1, 'Vendedor gen?rico de pruebas', 'Sin especificar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_administrador`),
  ADD UNIQUE KEY `uq_admin_usuario` (`id_usuario`);

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `fk_calif_pedido` (`id_pedido`),
  ADD KEY `fk_calif_comprador` (`id_comprador`),
  ADD KEY `fk_calif_vendedor` (`id_vendedor`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `fk_carrito_usuario` (`id_usuario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`),
  ADD KEY `fk_chat_comprador` (`id_comprador`),
  ADD KEY `fk_chat_vendedor` (`id_vendedor`);

--
-- Indices de la tabla `comprador`
--
ALTER TABLE `comprador`
  ADD PRIMARY KEY (`id_comprador`),
  ADD UNIQUE KEY `uq_comprador_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detcarrito_carrito` (`id_carrito`),
  ADD KEY `fk_detcarrito_producto` (`id_productos`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle_pedido`),
  ADD KEY `fk_detped_pedido` (`id_pedido`),
  ADD KEY `fk_detped_producto` (`id_productos`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `uq_factura_pedido` (`id_pedido`),
  ADD KEY `fk_factura_pago` (`id_pago`);

--
-- Indices de la tabla `historial_estado_pedido`
--
ALTER TABLE `historial_estado_pedido`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_histestado_pedido` (`id_pedido`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_mensaje_chat` (`id_chat`),
  ADD KEY `fk_mensaje_usuario` (`id_usuario`);

--
-- Indices de la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `fk_movinv_producto` (`id_productos`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `fk_notificacion_usuario` (`id_usuario`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_pago_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_productos`),
  ADD KEY `fk_productos_vendedor` (`id_vendedor`),
  ADD KEY `fk_productos_comprador` (`id_comprador`);

--
-- Indices de la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD PRIMARY KEY (`id_productos`,`id_categoria`),
  ADD KEY `fk_prodcat_categoria` (`id_categoria`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `fk_reporte_producto` (`id_productos`),
  ADD KEY `fk_reporte_usuario` (`id_usuario`);

--
-- Indices de la tabla `soporte_tecnico`
--
ALTER TABLE `soporte_tecnico`
  ADD PRIMARY KEY (`id_soporte`),
  ADD KEY `fk_soporte_usuario` (`id_usuario`),
  ADD KEY `fk_soporte_administrador` (`id_administrador`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uq_usuario_correo` (`correo`),
  ADD UNIQUE KEY `uq_usuario_documento` (`tipo_documento`,`numero_documento`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id_vendedor`),
  ADD UNIQUE KEY `uq_vendedor_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comprador`
--
ALTER TABLE `comprador`
  MODIFY `id_comprador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_estado_pedido`
--
ALTER TABLE `historial_estado_pedido`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `soporte_tecnico`
--
ALTER TABLE `soporte_tecnico`
  MODIFY `id_soporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id_vendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `fk_administrador_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `fk_calif_comprador` FOREIGN KEY (`id_comprador`) REFERENCES `comprador` (`id_comprador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_calif_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_calif_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_comprador` FOREIGN KEY (`id_comprador`) REFERENCES `comprador` (`id_comprador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chat_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comprador`
--
ALTER TABLE `comprador`
  ADD CONSTRAINT `fk_comprador_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_carrito`
--
ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `fk_detcarrito_carrito` FOREIGN KEY (`id_carrito`) REFERENCES `carrito` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detcarrito_producto` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detped_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detped_producto` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_pago` FOREIGN KEY (`id_pago`) REFERENCES `pago` (`id_pago`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_factura_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial_estado_pedido`
--
ALTER TABLE `historial_estado_pedido`
  ADD CONSTRAINT `fk_histestado_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `fk_mensaje_chat` FOREIGN KEY (`id_chat`) REFERENCES `chat` (`id_chat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mensaje_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimiento_inventario`
--
ALTER TABLE `movimiento_inventario`
  ADD CONSTRAINT `fk_movinv_producto` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `fk_notificacion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_comprador` FOREIGN KEY (`id_comprador`) REFERENCES `comprador` (`id_comprador`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_vendedor` FOREIGN KEY (`id_vendedor`) REFERENCES `vendedor` (`id_vendedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD CONSTRAINT `fk_prodcat_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodcat_producto` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `fk_reporte_producto` FOREIGN KEY (`id_productos`) REFERENCES `productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reporte_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `soporte_tecnico`
--
ALTER TABLE `soporte_tecnico`
  ADD CONSTRAINT `fk_soporte_administrador` FOREIGN KEY (`id_administrador`) REFERENCES `administrador` (`id_administrador`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_soporte_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT `fk_vendedor_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
