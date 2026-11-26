import React from "react";
import "./Navbar.css";

// Barra de navegación superior de AGRORED
function Navbar({ terminoBusqueda, alCambiarBusqueda }) {
  return (
    <nav>
      <div className="Navbar">
        <a href="/templates/index.html" className="logo-link">
          <img
            src="/static/img/Logo_letras.png"
            alt="Logo AGRORED"
            className="imagen_logo"
          />
        </a>
        <a href="#productos">Productos</a>
        <a href="#noticias">Noticias</a>
        <a href="#mejoras">Mejoras</a>
        <input
          type="search"
          placeholder="Arroz"
          value={terminoBusqueda}
          onChange={(e) => alCambiarBusqueda(e.target.value)}
        />

        <div className="botones">
          <a href="/templates/iniciar_sesion.html">
            <input type="button" value="Iniciar" className="Iniciar" />
          </a>
          <a href="/templates/registrarse.html">
            <input type="button" value="Registrarse" className="Registrarse" />
          </a>
        </div>
      </div>
    </nav>
  );
}

export default Navbar;