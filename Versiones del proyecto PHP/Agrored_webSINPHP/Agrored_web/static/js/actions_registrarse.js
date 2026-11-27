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

        // 1. Ningún campo obligatorio puede estar vacío
        if (nombre == '' || email == '' || telefono == '' || contrasena == '' ||
            numeroDocumento == '' || rol == '' || direccion == '' ||
            departamento == '' || municipio == ''){
                Swal.fire({
                title: "Ingresa todos los campos",
                icon: "error",
                draggable: true
                });
                return false;
            }else{
                Swal.fire({
                title: "Bienvenido " + nombre + "!",
                icon: "success",
                draggable: true
                });
                return true;
            }
    }