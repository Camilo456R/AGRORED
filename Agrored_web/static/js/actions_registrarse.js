document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Evitamos el envio normal para poder validar y mostrar la alerta primero

        if (!validarRegistro()) {
            return; // Los campos no son validos, la alerta de error ya se mostro dentro de validarRegistro()
        }

        enviarFormulario(form);
    });
});

function validarRegistro() {
    var nombre = document.getElementById('nombre').value;
    var email = document.getElementById('email').value;
    var telefono = document.getElementById('telefono').value;
    var contrasena = document.getElementById('contrasena').value;
    var numeroDocumento = document.getElementById('numeroDocumento').value;
    var rol = document.getElementById('rol').value;
    var direccion = document.getElementById('direccion').value;
    var departamento = document.getElementById('departamento').value;
    var municipio = document.getElementById('municipio').value;

    // Ningun campo obligatorio puede estar vacio
    if (nombre == '' || email == '' || telefono == '' || contrasena == '' ||
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
            return response.json();
        })
        .then(function (resultado) {
            if (resultado.exito) {
                Swal.fire({
                    title: "Bienvenido " + nombre + "!",
                    text: resultado.mensaje,
                    icon: "success",
                    draggable: true
                }).then(function () {
                    // Redirige al login una vez el usuario cierra la alerta
                    window.location.href = "/templates/iniciar_sesion.html";
                });
            } else {
                Swal.fire({
                    title: "No se pudo completar el registro",
                    text: resultado.mensaje,
                    icon: "error",
                    draggable: true
                });
                boton.disabled = false;
            }
        })
        .catch(function (error) {
            Swal.fire({
                title: "Error de conexion",
                text: "No se pudo contactar al servidor. Verifica que Apache y PHP esten activos.",
                icon: "error",
                draggable: true
            });
            console.error(error);
            boton.disabled = false;
        });
}
