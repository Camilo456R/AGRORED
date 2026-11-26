import React from "react";
import "./ProductoResumenPago.css";

function ProductoResumenPago({ producto }) {
  return (
    <div className="product-item">
      <img
        src={producto.imagen}
        alt={producto.alt || producto.nombre}
        className="product-img"
      />
      <div className="product-details">
        <span className="product-name">{producto.nombre}</span>
        <span className="product-price">${Number(producto.precio).toFixed(2)}</span>
      </div>
    </div>
  );
}

export default ProductoResumenPago;