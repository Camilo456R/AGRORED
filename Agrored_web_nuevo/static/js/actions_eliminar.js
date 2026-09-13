function eliminarproductos(){
    var boton = document.getElementsByName('eleminar_p');

    boton.forEach(function(boton) {
        boton.addEventListener('click', function() {
            Swal.fire({
                title: "¿Quieres eliminar este producto?",
                icon: "warning",
                draggable: true
            });
            return false;
            
        });
    });
}