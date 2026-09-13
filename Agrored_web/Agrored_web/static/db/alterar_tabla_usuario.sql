-- Ejecuta esto en phpMyAdmin (base de datos tablas_1) ANTES de usar procesar_registro.php
-- Agrega las columnas que el formulario de registro necesita y que la tabla `usuario` no tenía.

USE `tablas_1`;

ALTER TABLE `usuario`
  ADD COLUMN `contrasena` VARCHAR(255) DEFAULT NULL COMMENT 'Contraseña del usuario (guardada con hash, nunca en texto plano).',
  ADD COLUMN `tipo_documento` VARCHAR(10) DEFAULT NULL,
  ADD COLUMN `numero_documento` VARCHAR(20) DEFAULT NULL,
  ADD COLUMN `nombre_finca` VARCHAR(50) DEFAULT NULL,
  ADD COLUMN `departamento` VARCHAR(50) DEFAULT NULL,
  ADD COLUMN `municipio` VARCHAR(50) DEFAULT NULL,
  ADD COLUMN `codigo_postal` VARCHAR(10) DEFAULT NULL;
