document.addEventListener("DOMContentLoaded", () => {
    const radioTarjeta = document.getElementById("tarjeta");
    const radioPaypal = document.getElementById("paypal");
    const camposTarjeta = document.getElementById("campos-tarjeta");

    const inputTarjeta = document.getElementById("num-tarjeta");
    const inputExp = document.getElementById("exp-tarjeta");
    const inputCvc = document.getElementById("cvc-tarjeta");
    const inputNombre = document.getElementById("nombre-titular");
    
    const formPago = document.getElementById("form-pago");
    const btnCancelar = document.getElementById("btn-cancelar");
    const btnInfoCvc = document.getElementById("btn-info-cvc");
    const btnVale = document.getElementById("btn-vale");

function toggleMetodoPago() {
        if (radioTarjeta.checked) {
        camposTarjeta.classList.remove("hidden");
        } else {
        camposTarjeta.classList.add("hidden");
        }
    }

    radioTarjeta.addEventListener("change", toggleMetodoPago);
    radioPaypal.addEventListener("change", toggleMetodoPago);

    inputTarjeta.addEventListener("input", (e) => {
        let value = e.target.value.replace(/\D/g, "");
        value = value.replace(/(.{4})/g, "$1 ").trim();
        e.target.value = value;
    });

    inputExp.addEventListener("input", (e) => {
        let value = e.target.value.replace(/\D/g, "");
        if (value.length >= 2) {
            value = value.substring(0, 2) + "/" + value.substring(2, 4);
        }
        e.target.value = value;
        });

    inputCvc.addEventListener("input", (e) => {
        e.target.value = e.target.value.replace(/\D/g, "");
    });

    btnInfoCvc.addEventListener("click", () => {
        Swal.fire({
        title: 'Código CVC / CVV',
        text: 'Son los 3 o 4 dígitos de seguridad ubicados al respaldo de tu tarjeta de crédito o débito.',
        icon: 'info',
        confirmButtonColor: '#008a05'
        });
    });

    btnVale.addEventListener("click", async () => {
        const { value: codigoVale } = await Swal.fire({
        title: 'Ingresa tu Vale de Descuento',
        input: 'text',
        inputPlaceholder: 'Ej. CAMPO2026',
        showCancelButton: true,
        confirmButtonText: 'Aplicar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#008a05',
        inputValidator: (value) => {
            if (!value) {
            return '¡Debes ingresar un código!';
            }
        }
        });

        if (codigoVale) {
            if (codigoVale.toUpperCase() === "CAMPO2026") {
                Swal.fire({
                title: '¡Vale Aplicado!',
                text: 'Se ha aplicado un 10% de descuento a tu compra.',
                icon: 'success',
                confirmButtonColor: '#008a05'
                });
            document.getElementById("precio-total").textContent = "$11.87";
        } else {
                Swal.fire({
                title: 'Código Inválido',
                text: 'El vale ingresado no existe o ya venció.',
                icon: 'error',
                confirmButtonColor: '#d33'
                });
            }
        }
    });

    btnCancelar.addEventListener("click", () => {
        Swal.fire({
            title: '¿Cancelar proceso de pago?',
            text: "Serás redirigido a la tienda principal.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'Volver al pago'
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Cancelado',
                text: 'Operación cancelada exitosamente.',
                icon: 'info',
                timer: 1500,
                showConfirmButton: false
            });
        }
        });
    });

formPago.addEventListener("submit", (e) => {
        e.preventDefault();

        if (radioPaypal.checked) {
            Swal.fire({
                title: 'Redirigiendo a PayPal...',
                text: 'Por favor espera mientras conectamos con la plataforma.',
                icon: 'info',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            }).then(() => {
            Swal.fire({
                title: '¡Pago Exitoso!',
                text: 'Tu transacción por PayPal ha sido aprobada. ¡Gracias por apoyar el campo!',
                icon: 'success',
                confirmButtonColor: '#008a05'
            });
            });
            return;
            }

        const numVal = inputTarjeta.value.replace(/\s/g, "");
        const expVal = inputExp.value;
        const cvcVal = inputCvc.value;
        const nombreVal = inputNombre.value.trim();

        if (numVal.length < 15) {
            Swal.fire('Error', 'Ingresa un número de tarjeta válido (mínimo 15 dígitos).', 'error');
            return;
        }

        if (!/^\d{2}\/\d{2}$/.test(expVal)) {
            Swal.fire('Error', 'Ingresa una fecha de expiración válida en formato MM/AA.', 'error');
            return;
        }

        if (cvcVal.length < 3) {
            Swal.fire('Error', 'El código CVC/CVV debe tener al menos 3 dígitos.', 'error');
            return;
        }

        if (nombreVal === "") {
            Swal.fire('Error', 'Ingresa el nombre del titular de la tarjeta.', 'error');
            return;
        }

        Swal.fire({
            title: 'Procesando Pago',
            html: 'Validando datos con tu entidad bancaria...',
            allowOutsideClick: false,
            didOpen: () => {
            Swal.showLoading();
        }
        });

        setTimeout(() => {
        Swal.fire({
            title: '¡PAGO REALIZADO CON ÉXITO!',
            text: 'Tu orden ha sido registrada. Muchas gracias por apoyar a los productores del campo.',
            icon: 'success',
            confirmButtonColor: '#008a05'
        }).then(() => {
            formPago.reset();
            toggleMetodoPago();
        });
        }, 2000);
    });
    });