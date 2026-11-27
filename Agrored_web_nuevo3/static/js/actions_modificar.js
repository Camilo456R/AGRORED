// =========================================================
// VALIDACIÓN - FORMULARIO REGISTRAR PRODUCTO
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-producto");

    // Si esta página no tiene el formulario, no hace nada (evita errores en otras páginas)
    if (!form) return;

    const campos = {
        nombre: {
            input: document.getElementById("nombre"),
            error: document.getElementById("error-nombre"),
        },
        precio: {
            input: document.getElementById("precio"),
            error: document.getElementById("error-precio"),
        },
        descripcion: {
            input: document.getElementById("descripcion"),
            error: document.getElementById("error-descripcion"),
        },
        imagen: {
            input: document.getElementById("imagen"),
            error: document.getElementById("error-imagen"),
            caja: document.getElementById("dropzone-imagen"),
        },
    };

    const previewImagen = document.getElementById("preview-imagen");
    const textoDropzone = document.getElementById("texto-dropzone");
    const TAMANO_MAXIMO_MB = 5;
    const TIPOS_PERMITIDOS = ["image/png", "image/jpeg", "image/webp", "image/gif"];

    const tieneSweetAlert = typeof Swal !== "undefined";

    // ---------------------------------------------------
    // Reglas de validación por campo
    // Cada función recibe el valor y devuelve un mensaje de error,
    // o una cadena vacía si es válido.
    // ---------------------------------------------------

    function validarNombre(valor) {
        if (valor.trim() === "") {
            return "El nombre del producto es obligatorio.";
        }
        if (valor.trim().length < 3) {
            return "El nombre debe tener al menos 3 caracteres.";
        }
        if (valor.trim().length > 60) {
            return "El nombre no puede superar los 60 caracteres.";
        }
        return "";
    }

    function validarPrecio(valor) {
        if (valor.trim() === "") {
            return "El precio es obligatorio.";
        }

        // Acepta números con punto o coma decimal
        const valorNormalizado = valor.trim().replace(",", ".");
        const numero = Number(valorNormalizado);

        if (Number.isNaN(numero)) {
            return "El precio debe ser un número válido.";
        }
        if (numero <= 0) {
            return "El precio debe ser mayor a 0.";
        }
        if (numero > 1000000000) {
            return "El precio ingresado es demasiado alto.";
        }
        return "";
    }

    function validarDescripcion(valor) {
        if (valor.trim() === "") {
            return "La descripción es obligatoria.";
        }
        if (valor.trim().length < 10) {
            return "La descripción debe tener al menos 10 caracteres.";
        }
        if (valor.trim().length > 500) {
            return "La descripción no puede superar los 500 caracteres.";
        }
        return "";
    }

    function validarImagen(valor, archivos) {
        if (!archivos || archivos.length === 0) {
            return "Debes seleccionar una imagen para el producto.";
        }

        const archivo = archivos[0];

        if (!TIPOS_PERMITIDOS.includes(archivo.type)) {
            return "Formato no permitido. Usa una imagen .jpg, .png, .webp o .gif.";
        }

        const tamanoMB = archivo.size / (1024 * 1024);
        if (tamanoMB > TAMANO_MAXIMO_MB) {
            return "La imagen no puede pesar más de " + TAMANO_MAXIMO_MB + " MB.";
        }

        return "";
    }

    const validadores = {
        nombre: validarNombre,
        precio: validarPrecio,
        descripcion: validarDescripcion,
        imagen: validarImagen,
    };

    // ---------------------------------------------------
    // Mostrar / limpiar errores en pantalla
    // ---------------------------------------------------

    function mostrarError(campo, mensaje) {
        const elementoAResaltar = campo.caja || campo.input;
        elementoAResaltar.classList.add("campo-invalido");
        campo.error.textContent = mensaje;
    }

    function limpiarError(campo) {
        const elementoAResaltar = campo.caja || campo.input;
        elementoAResaltar.classList.remove("campo-invalido");
        campo.error.textContent = "";
    }

    function validarCampo(nombreCampo) {
        const campo = campos[nombreCampo];
        const valor = campo.input.value;
        const mensaje =
            nombreCampo === "imagen"
                ? validadores.imagen(valor, campo.input.files)
                : validadores[nombreCampo](valor);

        if (mensaje) {
            mostrarError(campo, mensaje);
            return false;
        }

        limpiarError(campo);
        return true;
    }

    // Validar en tiempo real mientras el usuario escribe (después de su primer intento)
    Object.keys(campos).forEach(function (nombreCampo) {
        campos[nombreCampo].input.addEventListener("input", function () {
            validarCampo(nombreCampo);
        });

        campos[nombreCampo].input.addEventListener("blur", function () {
            validarCampo(nombreCampo);
        });
    });

    // Vista previa de la imagen seleccionada
    campos.imagen.input.addEventListener("change", function () {
        const archivo = this.files && this.files[0];

        if (!archivo) {
            previewImagen.hidden = true;
            textoDropzone.hidden = false;
            return;
        }

        const lector = new FileReader();
        lector.onload = function (evento) {
            previewImagen.src = evento.target.result;
            previewImagen.hidden = false;
            textoDropzone.hidden = true;
        };
        lector.readAsDataURL(archivo);
    });

    // ---------------------------------------------------
    // Envío del formulario
    // ---------------------------------------------------

    form.addEventListener("submit", function (evento) {
        evento.preventDefault();

        let formularioValido = true;

        Object.keys(campos).forEach(function (nombreCampo) {
            const esValido = validarCampo(nombreCampo);
            if (!esValido) {
                formularioValido = false;
            }
        });

        if (!formularioValido) {
            // Lleva el foco al primer campo con error
            const primerCampoInvalido = Object.keys(campos).find(
                (nombreCampo) => campos[nombreCampo].error.textContent !== ""
            );
            if (primerCampoInvalido) {
                campos[primerCampoInvalido].input.focus();
            }

            if (tieneSweetAlert) {
                Swal.fire({
                    icon: "error",
                    title: "Revisa el formulario",
                    text: "Hay campos que necesitan corrección antes de continuar.",
                    confirmButtonColor: "#06bc67",
                });
            }
            return;
        }

        // Formulario válido: aquí normalmente se enviaría al servidor (fetch/AJAX)
        if (tieneSweetAlert) {
            Swal.fire({
                icon: "success",
                title: "¡Producto registrado!",
                text: "El producto se guardó correctamente.",
                confirmButtonColor: "#06bc67",
            });
        }

        form.reset();
        previewImagen.hidden = true;
        previewImagen.src = "";
        textoDropzone.hidden = false;
        Object.keys(campos).forEach(function (nombreCampo) {
            limpiarError(campos[nombreCampo]);
        });
    });
});
