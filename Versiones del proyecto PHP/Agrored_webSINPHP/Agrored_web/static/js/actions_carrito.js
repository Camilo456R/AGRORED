// ============================================================
// actions_carrito.js
// Validación de cantidades y cálculo del resumen del carrito
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

    const CANTIDAD_MIN = 1;
    const ENVIO_FIJO = 2500;
    const TASA_IMPUESTO = 0.10; // 10%

    const filas = document.querySelectorAll('.item-row');
    const btnComprar = document.querySelector('.btn-comprar');
    const btnVolver = document.querySelector('.btn-volver');

  // ---------- Utilidades ----------

  // Extrae el número desde un texto tipo "3 pcs"
function leerCantidad(input) {
    const numero = parseInt(input.value.replace(/[^\d]/g, ''), 10);
    return Number.isNaN(numero) ? NaN : numero;
}

  // Escribe la cantidad con el formato "N pcs"
function escribirCantidad(input, cantidad) {
    input.value = `${cantidad} pcs`;
}

function formatearMoneda(valor) {
    return '$' + valor.toLocaleString('es-CO', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

function mostrarAlerta(icono, titulo, texto) {
    if (window.Swal) {
        Swal.fire({ icon: icono, title: titulo, text: texto });
    } else {
        alert(`${titulo}: ${texto}`);
    }
}

  // ---------- Validación de una fila ----------

  // Valida y corrige la cantidad de una fila según sus límites (mínimo y stock)
function validarFila(fila) {
    const input = fila.querySelector('.qty-input');
    const stock = parseInt(fila.dataset.stock, 10) || 99;
    let cantidad = leerCantidad(input);

    if (Number.isNaN(cantidad)) {
        mostrarAlerta('warning', 'Cantidad inválida', 'Ingresa solo números. Se restableció a 1.');
        cantidad = CANTIDAD_MIN;
    } else if (cantidad < CANTIDAD_MIN) {
        mostrarAlerta('warning', 'Cantidad mínima', `La cantidad mínima por producto es ${CANTIDAD_MIN}.`);
        cantidad = CANTIDAD_MIN;
    } else if (cantidad > stock) {
        mostrarAlerta('warning', 'Sin stock suficiente', `Solo hay ${stock} unidades disponibles de este producto.`);
        cantidad = stock;
    }

    escribirCantidad(input, cantidad);
    return cantidad;
}

  // ---------- Cálculo del resumen ----------

function actualizarResumen() {
    let subtotal = 0;

    filas.forEach(fila => {
        const precio = parseFloat(fila.dataset.price) || 0;
        const input = fila.querySelector('.qty-input');
        const cantidad = leerCantidad(input) || 0;
      subtotal += precio * cantidad;
    });

    const envio = subtotal > 0 ? ENVIO_FIJO : 0;
    const impuesto = subtotal * TASA_IMPUESTO;
    const total = subtotal + envio + impuesto;

    document.getElementById('subtotal-value').textContent = formatearMoneda(subtotal);
    document.getElementById('envio-value').textContent = formatearMoneda(envio);
    document.getElementById('impuesto-value').textContent = formatearMoneda(impuesto);
    document.getElementById('total-value').textContent = formatearMoneda(total);

    // Deshabilita "Comprar" si el carrito está vacío
    btnComprar.disabled = subtotal <= 0;
    btnComprar.classList.toggle('disabled', subtotal <= 0);
}

  // ---------- Eventos por producto ----------

filas.forEach(fila => {
    const input = fila.querySelector('.qty-input');
    const btnUp = fila.querySelector('.qty-up');
    const btnDown = fila.querySelector('.qty-down');
    const stock = parseInt(fila.dataset.stock, 10) || 99;

    btnUp.addEventListener('click', () => {
        let cantidad = leerCantidad(input) || 0;
        if (cantidad >= stock) {
            mostrarAlerta('info', 'Límite alcanzado', `No puedes agregar más de ${stock} unidades.`);
            cantidad = stock;
        } else {
            cantidad += 1;
        }
        escribirCantidad(input, cantidad);
        actualizarResumen();
    });

    btnDown.addEventListener('click', () => {
            let cantidad = leerCantidad(input) || 0;
            cantidad = Math.max(cantidad - 1, CANTIDAD_MIN);
            escribirCantidad(input, cantidad);
            actualizarResumen();
        });

        // Valida cuando el usuario escribe manualmente y sale del campo
        input.addEventListener('blur', () => {
            validarFila(fila);
            actualizarResumen();
        });

        // Evita letras y símbolos mientras se escribe
        input.addEventListener('input', () => {
        input.value = input.value.replace(/[^\d]/g, '');
        });
    });

  // ---------- Validación general antes de comprar ----------

    btnComprar.addEventListener('click', (evento) => {
        evento.preventDefault();

    let carritoValido = true;
    let totalUnidades = 0;

    filas.forEach(fila => {
        const cantidad = validarFila(fila);
        if (Number.isNaN(cantidad) || cantidad < CANTIDAD_MIN) {
        carritoValido = false;
        }
        totalUnidades += cantidad;
    });

    actualizarResumen();

    if (!carritoValido) {
        mostrarAlerta('error', 'Carrito inválido', 'Revisa las cantidades marcadas antes de continuar.');
        return;
    }

    if (totalUnidades === 0) {
        mostrarAlerta('info', 'Carrito vacío', 'Agrega al menos un producto antes de comprar.');
        return;
    }

    mostrarAlerta('success', '¡Compra confirmada!', 'Tu pedido se procesó correctamente.');
    // Aquí puede ir la llamada real al backend, por ejemplo:
    // fetch('/api/comprar', { method: 'POST', body: JSON.stringify({...}) });
    });

  // ---------- Botón "Volver a tienda" ----------

    btnVolver.addEventListener('click', () => {
        window.location.href = '/templates/productos.html';
        });

  // ---------- Cálculo inicial al cargar la página ----------

    actualizarResumen();

});