import React from "react";
import "./ItemCarrito.css";

function ItemCarrito({ item, onCambiarCantidad, onEditarCantidad, formatearPrecio }) {
  return (
    <div className="item-row" data-price={item.precio} data-stock={item.stock}>
      <div className="item-img">
        <img src={item.imagen} alt={item.nombre} />
      </div>

      <div className="item-info">
        <h3>{item.nombre}</h3>
        <p>{item.descripcion}</p>
        <div className="price">{formatearPrecio(item.precio)}</div>
      </div>

      <div className="qty-box">
        <input
          type="text"
          className="qty-input"
          value={`${item.cantidad} pcs`}
          onChange={(e) => onEditarCantidad(item.id, e.target.value)}
          inputMode="numeric"
        />
        <div className="qty-arrows">
          <button
            type="button"
            className="qty-up"
            onClick={() => onCambiarCantidad(item.id, 1)}
            aria-label={`Aumentar cantidad de ${item.nombre}`}
          >
            &#9650;
          </button>
          <button
            type="button"
            className="qty-down"
            onClick={() => onCambiarCantidad(item.id, -1)}
            aria-label={`Disminuir cantidad de ${item.nombre}`}
          >
            &#9660;
          </button>
        </div>
      </div>
    </div>
  );
}

export default ItemCarrito;