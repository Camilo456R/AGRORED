import React, { useState } from "react";
import Swal from "sweetalert2";
import TarjetaProductoEliminar from "./TarjetaProductoEliminar";
import "./EliminarProductos.css";

// Datos iniciales tomados directamente del HTML original de eliminar productos
const PRODUCTOS_INICIALES = [
  {
    id: 1,
    nombre: "producto1",
    imagen: "/static/img/Papas.png",
    alt: "producto1",
    descripcion:
      "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Hic consequatur neque fuga vitae ratione repellat veniam enim saepe deserunt, corporis magni nisi minus facere obcaecati delectus. Soluta pariatur iure molestiae?",
    precio:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde neque quisquam eaque culpa.",
    unidades:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde neque quisquam eaque culpa.",
  },
];

// Componente padre: gestiona el listado y la eliminación con SweetAlert2
function EliminarProductos({ filtroBusqueda = "" }) {
  const [productos, setProductos] = useState(PRODUCTOS_INICIALES);

  const eliminarproductos = async (producto) => {
    const confirmacion = await Swal.fire({
      title: "¿Eliminar producto?",
      text: `Se eliminará "${producto.nombre}".`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    });

    if (!confirmacion.isConfirmed) return;

    setProductos((prev) => prev.filter((item) => item.id !== producto.id));

    Swal.fire({
      title: "Eliminado",
      text: "El producto fue eliminado correctamente.",
      icon: "success",
    });
  };

  const productosFiltrados = productos.filter((item) =>
    item.nombre.toLowerCase().includes(filtroBusqueda.toLowerCase()) ||
    item.descripcion.toLowerCase().includes(filtroBusqueda.toLowerCase())
  );

  return (
    <section className="tituloproductos">
      <div className="tituloproducto">
        <div>
          <h1>Productos</h1>
          <p>Acá se encuentran todos los productos que has subido</p>
        </div>
        <img src="/static/img/Znahoria.png" alt="Verduras" />
      </div>

      {productosFiltrados.length > 0 ? (
        productosFiltrados.map((producto) => (
          <TarjetaProductoEliminar
            key={producto.id}
            producto={producto}
            onEliminar={eliminarproductos}
          />
        ))
      ) : (
        <p>No hay productos disponibles para mostrar.</p>
      )}
    </section>
  );
}

export default EliminarProductos;