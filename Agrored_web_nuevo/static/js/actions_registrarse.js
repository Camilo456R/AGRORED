document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Evitamos el envio normal para validar y controlar la alerta primero

        if (!validarRegistro()) {
            return; // Los campos no son validos, la alerta de error ya se mostro
        }

        enviarFormulario(form);
    });
});

function validarRegistro() {
    var nombre = document.getElementById('nombre').value;
    var email = document.getElementById('correo').value;
    var celular = document.getElementById('celular').value;
    var contrasena = document.getElementById('contrasena').value;
    var numeroDocumento = document.getElementById('numeroDocumento').value;
    var rol = document.getElementById('rol').value;
    var direccion = document.getElementById('direccion').value;
    var departamento = document.getElementById('departamento').value;
    var municipio = document.getElementById('municipio').value;

    // Ningun campo obligatorio puede estar vacio
    if (nombre == '' || email == '' || celular == '' || contrasena == '' ||
        numeroDocumento == '' || rol == '' || direccion == '' ||
        departamento == '' || municipio == '') {
        Swal.fire({
            title: "Ingresa todos los campos",
            icon: "error",
            draggable: true
        });
        return false;
    }

    return true;
}

function enviarFormulario(form) {
    const datos = new FormData(form);
    const nombre = document.getElementById('nombre').value;
    const boton = form.querySelector('button[type="submit"]');

    boton.disabled = true; // Evita doble envio mientras esperamos la respuesta

    fetch(form.action, {
        method: 'POST',
        body: datos
    })
        .then(function (response) {
            // El PHP actual responde texto plano, no JSON, asi que lo leemos como texto
            return response.text();
        })
        .then(function (texto) {
            // El PHP escribe "...con exito" cuando todo sale bien
            var fueExitoso = texto.indexOf('exito') !== -1 && texto.indexOf('Hubo un error') === -1;

            if (fueExitoso) {
                Swal.fire({
                    title: "Bienvenido " + nombre + "!",
                    text: "Tu registro se completo correctamente.",
                    icon: "success",
                    draggable: true,
                    allowOutsideClick: false // obliga a darle click en "OK" antes de continuar
                }).then(function () {
                    // Solo redirige DESPUES de que el usuario cierra la alerta
                    window.location.href = "../templates/iniciar_sesion.html";
                });
            } else {
                Swal.fire({
                    title: "No se pudo completar el registro",
                    text: "Es posible que el correo o el numero de documento ya esten registrados.",
                    icon: "error",
                    draggable: true
                });
                boton.disabled = false;
            }
        })
        .catch(function (error) {
            Swal.fire({
                title: "Error de conexion",
                text: "No se pudo contactar al servidor. Verifica que Apache y MySQL esten activos.",
                icon: "error",
                draggable: true
            });
            console.error(error);
            boton.disabled = false;
        });
}