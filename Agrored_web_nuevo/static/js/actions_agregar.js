document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#form-producto');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); 

        if (!validarRegistro()) {
            return; 
        }

        enviarFormulario(form);
    });
});

function validarRegistro() {
    var nombre = document.getElementById('nombre').value.trim();
    var estado = document.getElementById('estado').value.trim();
    var descripcion = document.getElementById('descripcion').value.trim();
    var precio = document.getElementById('precio').value.trim();
    var stock = document.getElementById('stock').value.trim();

    // Validamos que los campos obligatorios del producto no estén vacíos
    if (nombre === '' || estado === '' || descripcion === '' || precio === '' || stock === '') {
        Swal.fire({
            title: "Ingresa todos los campos",
            text: "Asegúrate de llenar todos los datos del producto.",
            icon: "error",
            draggable: true
        });
        return false;
    }

    return true;
}

function enviarFormulario(form) {
    const datos = new FormData(form);
    const nombreProducto = document.getElementById('nombre').value;
    const boton = form.querySelector('button[type="submit"]');

    boton.disabled = true; // Evita el doble envío

    fetch(form.action, {
        method: 'POST',
        body: datos
    })
        .then(function (response) {
            return response.text();
        })
        .then(function (texto) {
            var textoMin = texto.toLowerCase();
            var fueExitoso = (textoMin.indexOf('exito') !== -1 || textoMin.indexOf('éxito') !== -1) && textoMin.indexOf('error') === -1;

            if (fueExitoso) {
                Swal.fire({
                    title: "¡Producto Registrado!",
                    text: "El producto " + nombreProducto + " se guardó correctamente.",
                    icon: "success",
                    draggable: true,
                    allowOutsideClick: false 
                }).then(function () {
                    window.location.href = "../templates/productos.html";
                });
            } else {
                Swal.fire({
                    title: "No se pudo registrar",
                    text: "Revisa los datos. Respuesta del servidor: " + texto.substring(0, 100),
                    icon: "error",
                    draggable: true
                });
                boton.disabled = false;
            }
        })
        .catch(function (error) {
            Swal.fire({
                title: "Error de conexión",
                text: "No se pudo contactar al servidor. Verifica que XAMPP/Apache esté activo.",
                icon: "error",
                draggable: true
            });
            console.error(error);
            boton.disabled = false;
        });
}