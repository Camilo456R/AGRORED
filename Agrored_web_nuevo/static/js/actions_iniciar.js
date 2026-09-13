// Cambia esto por el archivo real de tu dashboard/perfil
const REDIRECT_URL = "../templates/perfil.html"; // <-- reemplaza con tu archivo

document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', validaringreso);
    }
});

async function validaringreso(evento) {
    // Evitamos que el navegador haga el submit tradicional (eso lo dejaba en manos del PHP)
    evento.preventDefault();

    var email = document.getElementById('correo').value.trim();
    var contrasena = document.getElementById('contrasena').value;

    // 1. Ningún campo obligatorio puede estar vacío
    if (email === '' || contrasena === '') {
        Swal.fire({
            title: "Ingresa todos los campos",
            icon: "error",
            draggable: true
        });
        return;
    }

    try {
        const respuesta = await fetch("../static/php/iniciar_sesion.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ correo: email, contrasena: contrasena })
        });

        const datos = await respuesta.json();

        if (datos.success) {
            // La redirección ahora vive aquí, disparada por el propio SweetAlert
            Swal.fire({
                title: "¡Bienvenido!",
                icon: "success",
                draggable: true
            }).then(function () {
                window.location.href = REDIRECT_URL;
            });
        } else {
            Swal.fire({
                title: datos.message || "Correo o contraseña incorrectos",
                icon: "error",
                draggable: true
            });
        }
    } catch (error) {
        Swal.fire({
            title: "Error de conexión, intenta de nuevo",
            icon: "error",
            draggable: true
        });
    }
}