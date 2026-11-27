import React from "react";
import "./Footer.css";

// Pie de página de AGRORED
function Footer() {
  return (
    <footer className="pie-pagina">
      <div className="contenedor-footer">
        <div className="columna-footer">
          <h3>AGRORED</h3>
          <p>
            Conectando el campo con tu mesa. Llena el formulario y empieza a
            vender o comprar productos frescos de la mejor calidad.
          </p>
        </div>

        <div className="columna-footer">
          <h4>Navegación</h4>
          <ul>
            <li>
              <a href="#productos">Productos</a>
            </li>
            <li>
              <a href="#noticias">Noticias</a>
            </li>
            <li>
              <a href="#mejoras">Mejoras</a>
            </li>
            <li>
              <a href="#categorias">Categorías</a>
            </li>
          </ul>
        </div>

        <div className="columna-footer">
          <h4>Soporte</h4>
          <ul>
            <li>
              <a href="#faq">Preguntas Frecuentes</a>
            </li>
            <li>
              <a href="#terminos">Términos y Condiciones</a>
            </li>
            <li>
              <a href="#privacidad">Política de Privacidad</a>
            </li>
            <li>
              <a href="#contacto">Contacto</a>
            </li>
          </ul>
        </div>
      </div>

      <div className="copyright-footer">
        <p>&copy; 2026 AGRORED. Todos los derechos reservados.</p>
      </div>
    </footer>
  );
}

export default Footer;