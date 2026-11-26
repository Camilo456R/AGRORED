document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Evitamos el envio normal para controlar la respuesta JSON

        enviarLogin(form);
    });
});

function enviarLogin(form) {
    const datos = new FormData(form);
    const boton = form.querySelector('button[type="submit"]');

    boton.disabled = true; // Evita doble envio mientras esperamos la respuesta

    fetch(form.action, {
        method: 'POST',
        body: datos
    })
        .then(function (response) {
            return response.json(); // El PHP ya responde JSON
        })
        .then(function (data) {
            if (data.success) {
                Swal.fire({
                    title: "Bienvenido " + data.usuario.nombre + "!",
                    text: "Inicio de sesion exitoso.",
                    icon: "success",
                    draggable: true,
                    allowOutsideClick: false
                }).then(function () {
                    // Aqui puedes redirigir segun el rol si tienes paginas distintas
                    window.location.href = "../templates/index.html";
                });
            } else {
                Swal.fire({
                    title: "No se pudo iniciar sesion",
                    text: data.message || "Correo o contraseña incorrectos.",
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