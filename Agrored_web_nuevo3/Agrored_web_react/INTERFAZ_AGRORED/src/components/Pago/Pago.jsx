import React, { useState } from "react";
import Swal from "sweetalert2";
import ProductoResumenPago from "./ProductoResumenPago";
import "./Pago.css";

const PRODUCTOS_PAGO_INICIALES = [
  {
    id: 1,
    nombre: "Arándanos Orgánicos",
    precio: 4.99,
    imagen:
      "https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=100&auto=format&fit=crop&q=80",
    alt: "Arándanos",
  },
  {
    id: 2,
    nombre: "Mangos Ataulfo",
    precio: 3.5,
    imagen:
      "https://images.unsplash.com/photo-1553279768-865429fa0078?w=100&auto=format&fit=crop&q=80",
    alt: "Mangos",
  },
  {
    id: 3,
    nombre: "Manzanas Honeycrisp",
    precio: 1.5,
    imagen:
      "https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=100&auto=format&fit=crop&q=80",
    alt: "Manzanas",
  },
  {
    id: 4,
    nombre: "Peras Anjou",
    precio: 2.0,
    imagen:
      "https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=100&auto=format&fit=crop&q=80",
    alt: "Peras",
  },
];

const DATOS_PAGO_INICIALES = {
  metodo: "tarjeta", // "tarjeta" | "paypal"
  numeroTarjeta: "",
  expiracion: "",
  cvc: "",
  nombreTitular: "",
};

function Pago({ filtroBusqueda = "", onPagoCompletado, onCancelarPago }) {
  const [datosPago, setDatosPago] = useState(DATOS_PAGO_INICIALES);
  const [productos] = useState(PRODUCTOS_PAGO_INICIALES);

  const formatearNumeroTarjeta = (valor) => {
    const digitos = valor.replace(/\D/g, "").slice(0, 16);
    return digitos.replace(/(.{4})/g, "$1 ").trim();
  };

  const formatearExpiracion = (valor) => {
    const digitos = valor.replace(/\D/g, "").slice(0, 4);
    if (digitos.length <= 2) return digitos;
    return `${digitos.slice(0, 2)}/${digitos.slice(2)}`;
  };

  const manejarNumeroTarjeta = (e) => {
    setDatosPago((prev) => ({
      ...prev,
      numeroTarjeta: formatearNumeroTarjeta(e.target.value),
    }));
  };

  const manejarExpiracion = (e) => {
    setDatosPago((prev) => ({
      ...prev,
      expiracion: formatearExpiracion(e.target.value),
    }));
  };

  const manejarCvc = (e) => {
    const soloDigitos = e.target.value.replace(/\D/g, "").slice(0, 4);
    setDatosPago((prev) => ({
      ...prev,
      cvc: soloDigitos,
    }));
  };

  const manejarNombreTitular = (e) => {
    setDatosPago((prev) => ({
      ...prev,
      nombreTitular: e.target.value,
    }));
  };

  const cambiarMetodo = (metodo) => {
    setDatosPago((prev) => ({
      ...prev,
      metodo,
    }));
  };

  const mostrarInfoCvc = () => {
    Swal.fire({
      icon: "info",
      title: "¿Qué es el CVC/CVV?",
      text: "Es el código de seguridad de 3 o 4 dígitos ubicado al reverso (o frente) de tu tarjeta.",
      confirmButtonColor: "#008a05",
    });
  };

  const manejarVale = async () => {
    const { value: couponCode } = await Swal.fire({
      title: "Ingresa tu cupón",
      input: "text",
      inputPlaceholder: "Ej. AGRO2026",
      showCancelButton: true,
      confirmButtonColor: "#008a05",
      cancelButtonText: "Cancelar",
    });

    if (couponCode) {
      Swal.fire({
        icon: "info",
        title: "Validando vale...",
        text: `El cupón "${couponCode}" no es válido o ha expirado.`,
        confirmButtonColor: "#008a05",
      });
    }
  };

  const productosFiltrados = productos.filter((prod) =>
    prod.nombre.toLowerCase().includes(filtroBusqueda.toLowerCase())
  );

  const subtotal = productos.reduce((acc, item) => acc + item.precio, 0);
  const impuestos = Number((subtotal * 0.1).toFixed(2));
  const total = subtotal + impuestos;

  const manejarSubmit = async (e) => {
    e.preventDefault();

    if (datosPago.metodo === "tarjeta") {
      const digitosTarjeta = datosPago.numeroTarjeta.replace(/\s/g, "");
      if (
        digitosTarjeta.length < 13 ||
        datosPago.expiracion.length < 5 ||
        datosPago.cvc.length < 3 ||
        !datosPago.nombreTitular.trim()
      ) {
        Swal.fire({
          icon: "error",
          title: "Datos de tarjeta incompletos",
          text: "Completa el número de tarjeta, fecha MM/AA, CVC/CVV y nombre del titular.",
          confirmButtonColor: "#008a05",
        });
        return;
      }
    }

    const confirmacion = await Swal.fire({
      title: "¿Confirmar pago?",
      text: `Se procesará un pago de $${total.toFixed(2)} mediante ${
        datosPago.metodo === "tarjeta" ? "Tarjeta de crédito" : "PayPal"
      }.`,
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#008a05",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Pagar ahora",
    });

    if (!confirmacion.isConfirmed) return;

    await Swal.fire({
      icon: "success",
      title: "¡Pago aprobado!",
      text: "Gracias por apoyar al campo con AGRORED.",
      confirmButtonColor: "#008a05",
    });

    setDatosPago(DATOS_PAGO_INICIALES);
    if (typeof onPagoCompletado === "function") {
      onPagoCompletado({ metodo: datosPago.metodo, total });
    }
  };

  const manejarCancelar = () => {
    Swal.fire({
      title: "¿Cancelar pago?",
      text: "Se limpiarán los datos ingresados en el método de pago.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#6e7881",
      confirmButtonText: "Sí, cancelar",
      cancelButtonText: "Continuar aquí",
    }).then((result) => {
      if (result.isConfirmed) {
        setDatosPago(DATOS_PAGO_INICIALES);
        if (typeof onCancelarPago === "function") {
          onCancelarPago();
        }
      }
    });
  };

  return (
    <section className="pago-wrapper">
      <header className="header-pago">
        <h1>Pago</h1>
      </header>

      <main className="outer-card">
        <section className="thanks-banner">
          <h2>
            GRACIAS POR AYUDAR
            <br />
            AL CAMPO!!!
          </h2>
        </section>

        <div className="checkout-container">
          <section className="payment-section">
            <h3 className="payment-section-title">Método de pago</h3>

            <form id="form-pago" autoComplete="off" onSubmit={manejarSubmit}>
              <div className="card-option-box">
                <div className="card-header-option">
                  <input
                    type="radio"
                    id="tarjeta"
                    name="metodo"
                    value="tarjeta"
                    className="custom-radio"
                    checked={datosPago.metodo === "tarjeta"}
                    onChange={() => cambiarMetodo("tarjeta")}
                  />
                  <div className="header-text-container">
                    <label htmlFor="tarjeta" className="header-title">
                      Tarjeta de crédito
                    </label>
                    <span className="header-subtitle">
                      Paga de forma segura con tu tarjeta de crédito o débito.
                    </span>
                  </div>
                </div>

                {datosPago.metodo === "tarjeta" && (
                  <div id="campos-tarjeta">
                    <div className="inputs-row-top">
                      <div className="input-wrapper field-card-number">
                        <input
                          type="text"
                          id="num-tarjeta"
                          maxLength="19"
                          placeholder="Número de tarjeta"
                          value={datosPago.numeroTarjeta}
                          onChange={manejarNumeroTarjeta}
                        />
                        <div className="input-icon-right">
                          <div className="icon-card" />
                        </div>
                      </div>

                      <div className="input-wrapper field-exp">
                        <input
                          type="text"
                          id="exp-tarjeta"
                          maxLength="5"
                          placeholder="MM/AA"
                          value={datosPago.expiracion}
                          onChange={manejarExpiracion}
                        />
                      </div>

                      <div className="input-wrapper field-cvc">
                        <input
                          type="text"
                          id="cvc-tarjeta"
                          maxLength="4"
                          placeholder="CVC/CVV"
                          value={datosPago.cvc}
                          onChange={manejarCvc}
                        />
                        <div className="input-icon-right">
                          <button
                            type="button"
                            className="icon-info"
                            id="btn-info-cvc"
                            onClick={mostrarInfoCvc}
                            aria-label="Información sobre CVC/CVV"
                          >
                            i
                          </button>
                        </div>
                      </div>
                    </div>

                    <div className="input-wrapper field-name">
                      <input
                        type="text"
                        id="nombre-titular"
                        placeholder="Nombre del titular"
                        value={datosPago.nombreTitular}
                        onChange={manejarNombreTitular}
                      />
                    </div>
                  </div>
                )}
              </div>

              <div className="paypal-option-box">
                <div className="paypal-left">
                  <input
                    type="radio"
                    id="paypal"
                    name="metodo"
                    value="paypal"
                    className="custom-radio"
                    checked={datosPago.metodo === "paypal"}
                    onChange={() => cambiarMetodo("paypal")}
                  />
                  <div className="header-text-container">
                    <label htmlFor="paypal" className="header-title">
                      PayPal
                    </label>
                    <span className="header-subtitle">
                      Pagarás a través de tu cuenta de PayPal.
                    </span>
                  </div>
                </div>
                <div className="paypal-logo">PayPal</div>
              </div>

              <div className="action-buttons">
                <button type="submit" className="btn-pagar" id="btn-pagar">
                  Pagar ahora
                </button>
                <button
                  type="button"
                  className="btn-cancelar"
                  id="btn-cancelar"
                  onClick={manejarCancelar}
                >
                  Cancelar
                </button>
              </div>
            </form>
          </section>

          <section className="summary-section">
            <h3 className="summary-title">Resumen</h3>

            <div className="products-grid">
              {productosFiltrados.length > 0 ? (
                productosFiltrados.map((producto) => (
                  <ProductoResumenPago key={producto.id} producto={producto} />
                ))
              ) : (
                <p className="resumen-vacio">
                  No hay productos que coincidan con tu búsqueda.
                </p>
              )}
            </div>

            <div
              className="coupon-row"
              id="btn-vale"
              role="button"
              tabIndex={0}
              onClick={manejarVale}
            >
              <span>¿TIENES UN VALE?</span>
              <span>▼</span>
            </div>

            <table className="totals-table">
              <tbody>
                <tr>
                  <td>SUBTOTAL</td>
                  <td className="amount">${subtotal.toFixed(2)}</td>
                </tr>
                <tr>
                  <td>ENVÍO</td>
                  <td className="amount">GRATIS</td>
                </tr>
                <tr>
                  <td>IMPUESTOS</td>
                  <td className="amount">${impuestos.toFixed(2)}</td>
                </tr>
                <tr className="total-row">
                  <td>TOTAL</td>
                  <td className="amount" id="precio-total">
                    ${total.toFixed(2)}
                  </td>
                </tr>
              </tbody>
            </table>
          </section>
        </div>
      </main>
    </section>
  );
}

export default Pago;