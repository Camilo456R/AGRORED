
import React, { useState } from "react";
import Swal from "sweetalert2";
import "../static/css/registrarse.css";

import logoLetras from "../static/img/Logo_letras.png";
import logoIcono from "../static/img/Logo.png";

function Registrarse() {

  const [enviando, setEnviando] = useState(false);
  const [mostrarPassword, setMostrarPassword] = useState(false);

  // FUNCIÓN PARA VALIDAR EL FORMULARIO
  const handleSubmit = (e) => {
    e.preventDefault();

    const form = e.target;
    const datos = new FormData(form);

    // Obtener datos
    const P_nombre = datos.get("P_nombre")?.trim();
    const S_nombre = datos.get("S_nombre")?.trim();
    const P_apellido = datos.get("P_apellido")?.trim();
    const S_apellido = datos.get("S_apellido")?.trim();

    const email = datos.get("correo")?.trim();
    const celular = datos.get("celular")?.trim();
    const contrasena = datos.get("contrasena");
    const tipoDocumento = datos.get("tipo_documento");
    const numeroDocumento = datos.get("numero_documento")?.trim();
    const rol = datos.get("rol");
    const direccion = datos.get("direccion")?.trim();
    const departamento = datos.get("departamento")?.trim();
    const municipio = datos.get("municipio")?.trim();

    // VALIDAR CAMPOS OBLIGATORIOS
    if (
      !P_nombre ||
      !P_apellido ||
      !email ||
      !celular ||
      !contrasena ||
      !tipoDocumento ||
      !numeroDocumento ||
      !rol ||
      !direccion ||
      !departamento ||
      !municipio
    ) {
      Swal.fire({
        title: "Ingresa todos los campos obligatorios",
        icon: "error"
      });
      return;
    }

    // VALIDAR CONTRASEÑA
    if (contrasena.length < 8) {
      Swal.fire({
        title: "Contraseña muy corta",
        text: "La contraseña debe tener al menos 8 caracteres.",
        icon: "warning"
      });
      return;
    }

    // SIMULACIÓN DE REGISTRO EXITOSO
    setEnviando(true);

    Swal.fire({
      title: `¡Bienvenido ${P_nombre}!`,
      text: "Tu registro se completó correctamente.",
      icon: "success",
      allowOutsideClick: false
    }).then(() => {
      form.reset();
      setEnviando(false);
    });
  };

  return (
    <>

      {/* ================= NAVBAR ================= */}

      <nav className="Navbar">

        {/* LOGO */}
        <a href="/" className="logo-link">
          <img
            src={logoLetras}
            alt="Logo AgroRed"
            className="imagen_logo"
          />
        </a>

        {/* ENLACES */}
        <a href="/productos">Productos</a>
        <a href="/noticias">Noticias</a>
        <a href="/mejoras">Mejoras</a>

        {/* BUSCADOR */}
        <input
          type="search"
          placeholder="Arroz"
        />

        {/* BOTONES */}
        <div className="botones">

          <a href="/iniciar-sesion">
            <input
              type="button"
              value="Iniciar"
              className="Iniciar"
            />
          </a>

          <a href="/registrarse">
            <input
              type="button"
              value="Registrarse"
              className="Registrarse"
            />
          </a>

        </div>

      </nav>


      {/* ================= REGISTRO ================= */}

      <div className="register-container">

        {/* IMAGEN LATERAL */}
        <div className="register-image">

          <img
            src="https://images.pexels.com/photos/1267325/pexels-photo-1267325.jpeg?auto=compress&cs=tinysrgb&w=1200"
            alt="Transporte y distribución agrícola"
          />

          <div className="image-overlay">

            <h2>
              Cosechamos
              <br />
              Oportunidades
              <br />
              Para Todos.
            </h2>

          </div>

        </div>


        {/* ================= FORMULARIO ================= */}

        <div className="register-form-section">

          {/* LOGO DEL FORMULARIO */}
          <div className="logo-reg">

            <img
              src={logoIcono}
              alt="AgroRed"
              height="30"
            />

            <div>
              AGRO<span>RED</span>
            </div>

          </div>

          <h3>Crear cuenta</h3>

          <p className="subtitle">
            Únete a la red que conecta el campo con la ciudad.
          </p>


          <form onSubmit={handleSubmit}>

            {/* PRIMER NOMBRE */}
            <div className="input-group">

              <label>Primer Nombre</label>

              <input
                type="text"
                name="P_nombre"
                placeholder="Escribe tu primer nombre"
                required
              />

            </div>


            {/* SEGUNDO NOMBRE */}
            <div className="input-group">

              <label>Segundo Nombre</label>

              <input
                type="text"
                name="S_nombre"
                placeholder="Escribe tu segundo nombre"
              />

            </div>


            {/* PRIMER APELLIDO */}
            <div className="input-group">

              <label>Primer Apellido</label>

              <input
                type="text"
                name="P_apellido"
                placeholder="Escribe tu primer apellido"
                required
              />

            </div>


            {/* SEGUNDO APELLIDO */}
            <div className="input-group">

              <label>Segundo Apellido</label>

              <input
                type="text"
                name="S_apellido"
                placeholder="Escribe tu segundo apellido"
              />

            </div>


            {/* CORREO ELECTRÓNICO */}
            <div className="input-group">

              <label>Correo Electrónico</label>

              <input
                type="email"
                name="correo"
                placeholder="ejemplo@correo.com"
                required
              />

            </div>


            {/* CELULAR */}
            <div className="input-group">

              <label>Número de Celular</label>

              <input
                type="tel"
                name="celular"
                placeholder="300 000 0000"
                required
              />

            </div>


            {/* CONTRASEÑA */}
            <div className="input-group full-width password-wrapper">

              <label>Contraseña</label>

              <input
                type={mostrarPassword ? "text" : "password"}
                name="contrasena"
                placeholder="Mínimo 8 caracteres"
                minLength="8"
                required
              />

              <button
                type="button"
                className="toggle-password"
                onClick={() =>
                  setMostrarPassword(!mostrarPassword)
                }
              >
                {mostrarPassword ? "Ocultar" : "Mostrar"}
              </button>

            </div>


            {/* TIPO DE DOCUMENTO */}
            <div className="input-group">

              <label>Tipo de Documento</label>

              <select
                name="tipo_documento"
                required
                defaultValue=""
              >

                <option value="" disabled>
                  Selecciona tu documento
                </option>

                <option value="CC">
                  Cédula de Ciudadanía
                </option>

                <option value="CE">
                  Cédula de Extranjería
                </option>

                <option value="NIT">
                  NIT
                </option>

              </select>

            </div>


            {/* NÚMERO DE DOCUMENTO */}
            <div className="input-group">

              <label>Número de Documento</label>

              <input
                type="text"
                name="numero_documento"
                placeholder="Número de documento"
                required
              />

            </div>


            {/* ROL */}
            <div className="input-group full-width">

              <label>¿Cuál es tu perfil?</label>

              <select
                name="rol"
                required
                defaultValue=""
              >

                <option value="" disabled>
                  Selecciona tu perfil
                </option>

                <option value="comprador">
                  Comprador
                </option>

                <option value="vendedor">
                  Productor / Vendedor
                </option>

              </select>

            </div>


            {/* DIRECCIÓN */}
            <div className="input-group full-width">

              <label>Dirección</label>

              <input
                type="text"
                name="direccion"
                placeholder="Calle, carrera, número..."
                required
              />

            </div>


            {/* DEPARTAMENTO */}
            <div className="input-group">

              <label>Departamento</label>

              <input
                type="text"
                name="departamento"
                placeholder="Departamento"
                required
              />

            </div>


            {/* MUNICIPIO */}
            <div className="input-group">

              <label>Municipio</label>

              <input
                type="text"
                name="municipio"
                placeholder="Ciudad o municipio"
                required
              />

            </div>


            {/* CÓDIGO POSTAL */}
            <div className="input-group full-width">

              <label>Código Postal</label>

              <input
                type="text"
                name="codigo_postal"
                placeholder="Código postal (opcional)"
              />

            </div>


            {/* BOTÓN REGISTRARSE */}
            <button
              type="submit"
              className="btn-register"
              disabled={enviando}
            >

              {enviando
                ? "Registrando..."
                : "Completar registro"}

            </button>

          </form>

        </div>

      </div>


      {/* ================= FOOTER ================= */}

      <footer className="pie-pagina">

        <div className="contenedor-footer">

          {/* COLUMNA 1 */}
          <div className="columna-footer">

            <h3>AGRORED</h3>

            <p>
              Conectando el campo con tu mesa.
              Compra y vende productos agrícolas
              de la mejor calidad.
            </p>

          </div>


          {/* COLUMNA 2 */}
          <div className="columna-footer">

            <h4>Navegación</h4>

            <ul>
              <li><a href="/productos">Productos</a></li>
              <li><a href="/noticias">Noticias</a></li>
              <li><a href="/mejoras">Mejoras</a></li>
            </ul>

          </div>


          {/* COLUMNA 3 */}
          <div className="columna-footer">

            <h4>Soporte</h4>

            <ul>
              <li><a href="#">Preguntas Frecuentes</a></li>
              <li><a href="#">Términos y Condiciones</a></li>
              <li><a href="#">Política de Privacidad</a></li>
              <li><a href="#">Contacto</a></li>
            </ul>

          </div>

        </div>


        {/* COPYRIGHT */}
        <div className="copyright-footer">

          <p>
            © 2026 AGRORED. Todos los derechos reservados.
          </p>

        </div>

      </footer>

    </>
  );
}

export default Registrarse;
