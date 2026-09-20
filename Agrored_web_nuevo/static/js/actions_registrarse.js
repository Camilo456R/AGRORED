
// Parte que funciona para el envio del formulario con las alertas de SweetAlert--------------------
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

//Parte que funciona para el icono de la contraseña (Ver y ocultar) ----------------------------------------------------------
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('contrasena');
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });
// Fin Parte que funciona para el icono de la contraseña (Ver y ocultar) ----------------------------------------------------------


    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Evitamos el envio normal para validar y controlar la alerta primero

        if (!validarRegistro()) {
            return; // Los campos no son validos, la alerta de error ya se mostro
        }

        enviarFormulario(form);
    });
});

// Fin Parte que funciona para el envio del formulario con las alertas de SweetAlert--------------------


// Funcion que de validacion de registro----------------------------------------------------------------------------------
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

// Comprobacion si estan todos los datos llenos en el formulario------------------------------------------
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
// Fin Funcion que de validacion de registro----------------------------------------------------------------------------------



// Funcion de enviar el formulario----------------------------------------------------------------------------------------
function enviarFormulario(form) {
    const datos = new FormData(form);
    const nombre = document.getElementById('nombre').value;
    const boton = form.querySelector('button[type="submit"]');

    boton.disabled = true; // Evita doble envio de datos

// Semaforo de comprobacion--------------------------------------------------------------------------------------------
    fetch(form.action, { //Seleccionar el metodo
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

// Comprobaciones de exito o fallo---------------------------------------------------------------------------
            if (fueExitoso) {
                Swal.fire({
                    title: "Bienvenido " + nombre + "!",
                    text: "Tu registro se completo correctamente.",
                    icon: "success",
                    draggable: true,
                    allowOutsideClick: false // obliga a darle click en "OK" antes de continuar

                // Esto funciona para redirigir a inicar sesion solo despues de precionar el boton
                }).then(function () {
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
        // Condicion si hubo algun error con php o la base de datos--------------------------------------------------------------------------
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