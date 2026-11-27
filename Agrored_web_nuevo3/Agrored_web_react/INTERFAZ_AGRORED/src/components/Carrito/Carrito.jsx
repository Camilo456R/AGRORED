import React, { useState } from "react";
import Swal from "sweetalert2";
import ItemCarrito from "./ItemCarrito";
import "./Carrito.css";

const PRODUCTOS_CARRITO_INICIALES = [
  {
    id: 1,
    nombre: "MANZANA",
    descripcion: "Manzana dulce, crujiente y jugosa, perfecta para un snack.",
    precio: 1.5,
    stock: 20,
    cantidad: 1,
    imagen: "https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=200",
  },
  {
    id: 2,
    nombre: "PERA",
    descripcion: "Fruta suave y dulce con un ligero toque cítrico, ideal para ensaladas.",
    precio: 2.0,
    stock: 20,
    cantidad: 1,
    imagen: "https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=200",
  },
  {
    id: 3,
    nombre: "MANGO",
    descripcion: "Conocido por su sabor dulce y pulpa mantecosa, sin hebras.",
    precio: 3.5,
    stock: 20,
    cantidad: 1,
    imagen: "https://images.unsplash.com/photo-1591073113125-e46713c829ed?w=200",
  },
];

function Carrito({ filtroBusqueda = "", onVolverTienda }) {
  const [items, setItems] = useState(PRODUCTOS_CARRITO_INICIALES);

  const cambiarCantidad = (idProducto, delta) => {
    setItems((prev) =>
      prev.map((item) => {
        if (item.id !== idProducto) return item;
        const siguiente = item.cantidad + delta;
        if (siguiente < 1) return { ...item, cantidad: 1 };
        if (siguiente > item.stock) {
          Swal.fire({
            title: "Stock máximo alcanzado",
            text: `Solo hay ${item.stock} pcs disponibles de ${item.nombre}.`,
            icon: "info",
          });
          return { ...item, cantidad: item.stock };
        }
        return { ...item, cantidad: siguiente };
      })
    );
  };

  const editarCantidad = (idProducto, valorTexto) => {
    const soloNumeros = parseInt(valorTexto.replace(/\D/g, ""), 10);
    setItems((prev) =>
      prev.map((item) => {
        if (item.id !== idProducto) return item;
        if (Number.isNaN(soloNumeros) || soloNumeros < 1) {
          return { ...item, cantidad: 1 };
        }
        const limitada = Math.min(soloNumeros, item.stock);
        return { ...item, cantidad: limitada };
      })
    );
  };

  const formatearPrecio = (valor) => `$${Number(valor).toFixed(2)}`;

  const itemsFiltrados = items.filter(
    (item) =>
      item.nombre.toLowerCase().includes(filtroBusqueda.toLowerCase()) ||
      item.descripcion.toLowerCase().includes(filtroBusqueda.toLowerCase())
  );

  const subtotal = items.reduce(
    (acc, item) => acc + item.precio * item.cantidad,
    0
  );
  const envio = items.length > 0 ? 2.5 : 0;
  const impuesto = subtotal * 0.1;
  const total = subtotal + envio + impuesto;

  const manejarCompra = async () => {
    if (items.length === 0) return;

    const resultado = await Swal.fire({
      title: "¿Confirmar compra?",
      text: `Total a pagar: ${formatearPrecio(total)}`,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Comprar",
      cancelButtonText: "Cancelar",
    });

    if (!resultado.isConfirmed) return;

    await Swal.fire({
      title: "¡Compra realizada!",
      text: "Tu pedido ha sido procesado correctamente.",
      icon: "success",
    });

    setItems([]);
  };

  const manejarVolver = () => {
    if (typeof onVolverTienda === "function") {
      onVolverTienda();
      return;
    }
    window.history.back();
  };

  return (
    <div className="page">
      <h1 className="titulo">Carrito</h1>

      <div className="cart-card">
        {itemsFiltrados.length > 0 ? (
          itemsFiltrados.map((item) => (
            <ItemCarrito
              key={item.id}
              item={item}
              onCambiarCantidad={cambiarCantidad}
              onEditarCantidad={editarCantidad}
              formatearPrecio={formatearPrecio}
            />
          ))
        ) : (
          <p className="carrito-sin-resultados">
            No se encontraron productos en el carrito.
          </p>
        )}

        <hr className="divider" />

        <div className="bottom-section">
          <div className="summary-col">
            <div className="summary-box">
              <div className="line">
                <span>Subtotal:</span>
                <span id="subtotal-value">{formatearPrecio(subtotal)}</span>
              </div>
              <div className="line">
                <span>Envío:</span>
                <span id="envio-value">{formatearPrecio(envio)}</span>
              </div>
              <div className="line">
                <span>Impuesto:</span>
                <span id="impuesto-value">{formatearPrecio(impuesto)}</span>
              </div>
            </div>
            <div className="total-box">
              Total: <span id="total-value">{formatearPrecio(total)}</span>
            </div>
          </div>

          <div className="action-col">
            <button
              type="button"
              className="btn btn-comprar"
              onClick={manejarCompra}
              disabled={items.length === 0}
            >
              Comprar &#128722;
            </button>
            <button
              type="button"
              className="btn btn-volver"
              onClick={manejarVolver}
            >
              &#9664;&#9664;&#9664; Volver a tienda
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Carrito;