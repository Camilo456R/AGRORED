    function validaringreso() {
        var email = document.getElementById('email').value;
        var contrasena = document.getElementById('contrasena').value;

        // 1. Ningún campo obligatorio puede estar vacío
        if (email == '' || contrasena == ''){
                Swal.fire({
                title: "Ingresa todos los campos",
                icon: "error",
                draggable: true
                });
                return false;
            }else{
                Swal.fire({
                title: "Bienvenido " + email + "!",
                icon: "success",
                draggable: true
                });
                return true;
            }
    }