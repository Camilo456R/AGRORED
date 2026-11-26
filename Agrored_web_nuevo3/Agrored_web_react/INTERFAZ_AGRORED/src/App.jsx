import { useState } from "react";
import Navbar from "./components/Navbar/Navbar";
import Carrito from "./components/Carrito/Carrito";
import Pago from "./components/Pago/Pago";
import EliminarProductos from "./components/EliminarProductos/EliminarProductos";
import Footer from "./components/Footer/Footer";

function App() {
  const [filtroBusqueda, setFiltroBusqueda] = useState("");
  const [vistaActiva, setVistaActiva] = useState("carrito"); // "carrito" | "pago" | "eliminar"

  const estiloBoton = (activa) => ({
    padding: "8px 16px",
    borderRadius: "8px",
    border: "none",
    cursor: "pointer",
    fontWeight: "bold",
    backgroundColor: activa ? "#06bc67" : "#e5e5e5",
    color: activa ? "#ffffff" : "#1a1a1a",
  });

  return (
    <>
      <Navbar
        busqueda={filtroBusqueda}
        onBuscarChange={(e) => setFiltroBusqueda(e.target.value)}
      />

      <div
        style={{
          display: "flex",
          justifyContent: "center",
          flexWrap: "wrap",
          gap: "12px",
          padding: "12px",
          backgroundColor: "#ffffff",
          borderBottom: "1px solid #e0e0e0",
        }}
      >
        <button
          type="button"
          onClick={() => setVistaActiva("carrito")}
          style={estiloBoton(vistaActiva === "carrito")}
        >
          Ver Carrito
        </button>

        <button
          type="button"
          onClick={() => setVistaActiva("pago")}
          style={estiloBoton(vistaActiva === "pago")}
        >
          Ver Pago
        </button>

        <button
          type="button"
          onClick={() => setVistaActiva("eliminar")}
          style={estiloBoton(vistaActiva === "eliminar")}
        >
          Ver Eliminar Productos
        </button>
      </div>

      {vistaActiva === "carrito" && (
        <Carrito
          filtroBusqueda={filtroBusqueda}
          onVolverTienda={() => setVistaActiva("eliminar")}
        />
      )}

      {vistaActiva === "pago" && (
        <Pago
          filtroBusqueda={filtroBusqueda}
          onCancelarPago={() => setVistaActiva("carrito")}
          onPagoCompletado={() => setVistaActiva("carrito")}
        />
      )}

      {vistaActiva === "eliminar" && (
        <EliminarProductos filtroBusqueda={filtroBusqueda} />
      )}

      <Footer />
    </>
  );
}

export default App;