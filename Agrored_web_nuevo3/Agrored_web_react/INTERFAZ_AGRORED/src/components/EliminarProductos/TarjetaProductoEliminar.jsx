import React from "react";
import "./TarjetaProductoEliminar.css";

// Componente hijo: recibe producto y onEliminar por props
function TarjetaProductoEliminar({ producto, onEliminar }) {
  return (
    <div className="opciones">
      <div className="imagen">
        <img src={producto.imagen} alt={producto.alt || producto.nombre} />
        <p id="descripcion">{producto.descripcion}</p>
      </div>

      <div className="atributos">
        <div className="atributo-item">
          <label htmlFor={`precio-${producto.id}`}>Precio</label>
          <p id={`precio-${producto.id}`} className="parrafo">
            {producto.precio}
          </p>
        </div>

        <div className="atributo-item">
          <label htmlFor={`unidades-${producto.id}`}>Unidades</label>
          <p id={`unidades-${producto.id}`} className="parrafo2">
            {producto.unidades}
          </p>
        </div>
      </div>

      <button
        className="eliminar"
        type="button"
        onClick={() => onEliminar(producto)}
      >
        Eliminar
      </button>
    </div>
  );
}

export default TarjetaProductoEliminar;