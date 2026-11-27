
import React, { useState } from "react";
import Swal from "sweetalert2";

import "../static/css/registrar_productos.css";

import logoLetras from "../static/img/Logo_letras.png";
import logoIcono from "../static/img/Logo.png";


function RegistrarProducto() {
    const [enviando, setEnviando] = useState(false);
    const [imagen, setImagen] = useState(null);
    const [preview, setPreview] = useState(null);

    // Seleccionar y mostrar imagen
    const manejarImagen = (e) => {
        const archivo = e.target.files[0];

        if (archivo) {
            if (!archivo.type.startsWith("image/")) {
                Swal.fire("Error", "Selecciona un archivo de imagen válido.", "error");
                e.target.value = "";
                return;
            }

            setImagen(archivo);
            setPreview(URL.createObjectURL(archivo));
        }
    };

    // Registrar producto
    const manejarEnvio = async (e) => {
        e.preventDefault();

        const formulario = e.target;

        const nombre = formulario.nombre.value.trim();
        const estado = formulario.estado_producto.value.trim();
        const descripcion = formulario.descripcion.value.trim();
        const stock = formulario.stock.value;
        const precio = formulario.precio.value;

        if (!nombre || !estado || !descripcion || !stock || !precio) {
            Swal.fire("Atención", "Completa todos los campos.", "warning");
            return;
        }

        if (Number(stock) < 0 || !Number.isInteger(Number(stock))) {
            Swal.fire("Error", "El stock debe ser un número entero mayor o igual a cero.", "error");
            return;
        }

        if (Number(precio) < 0) {
            Swal.fire("Error", "El precio no puede ser negativo.", "error");
            return;
        }

        setEnviando(true);

       
      

        try {
            await Swal.fire({
                title: "¡Producto listo!",
                text: "Los datos fueron validados correctamente.",
                icon: "success",
                confirmButtonText: "Aceptar"
            });

            formulario.reset();
            setImagen(null);
            setPreview(null);

        } catch (error) {
            Swal.fire("Error", "No se pudo procesar el formulario.", "error");
        } finally {
            setEnviando(false);
        }
    };

    return (
        <>
            {/* NAVBAR */}
            <nav className="Navbar">

                <a href="#" className="logo-link">
                    <img
                        src={logoLetras}
                        alt="Logo AgroRed"
                        className="imagen_logo"
                    />
                </a>

                <a href="#">Productos</a>
                <a href="#">Noticias</a>
                <a href="#">Mejoras</a>

                <input
                    type="search"
                    placeholder="Buscar..."
                />

                <div className="botones">
                    <input
                        type="button"
                        className="Iniciar"
                        value="Iniciar"
                    />

                    <input
                        type="button"
                        className="Registrarse"
                        value="Registrarse"
                    />
                </div>
            </nav>

            {/* FORMULARIO */}
            <main className="form-wrapper">

                <section className="card">

                    <img
                        src={logoLetras}
                        alt="AgroRed"
                        style={{ width: "180px", marginBottom: "15px" }}
                    />

                    <h1>Registrar Producto</h1>

                    <form
                        id="form-producto"
                        onSubmit={manejarEnvio}
                    >

                        <input
                            type="text"
                            name="nombre"
                            className="field"
                            placeholder="Nombre del producto"
                            required
                        />

                        <input
                            type="text"
                            name="estado_producto"
                            className="field"
                            placeholder="Estado del producto"
                            required
                        />

                        <textarea
                            name="descripcion"
                            className="field"
                            placeholder="Descripción del producto"
                            required
                        />

                        <input
                            type="number"
                            name="stock"
                            className="field"
                            placeholder="Cantidad disponible"
                            min="0"
                            step="1"
                            required
                        />

                        <input
                            type="number"
                            name="precio"
                            className="field"
                            placeholder="Precio del producto"
                            min="0"
                            step="0.01"
                            required
                        />

                        {/* SELECCIONAR IMAGEN */}
                        <label
                            className="campo-imagen"
                            htmlFor="imagen"
                        >
                            {preview ? (
                                <img
                                    src={preview}
                                    alt="Vista previa del producto"
                                    className="preview-imagen"
                                />
                            ) : (
                                <span className="texto-dropzone">
                                    Haz clic aquí para seleccionar una imagen
                                </span>
                            )}
                        </label>

                        <input
                            type="file"
                            id="imagen"
                            name="imagen"
                            accept="image/*"
                            onChange={manejarImagen}
                            hidden
                        />

                        {/* BOTÓN */}
                        <button
                            type="submit"
                            className="crear"
                            disabled={enviando}
                        >
                            {enviando ? "Procesando..." : "Crear"}
                        </button>

                    </form>
                </section>
            </main>

            {/* FOOTER */}
            <footer className="pie-pagina">

                <div className="contenedor-footer">

                    <div className="columna-footer">
                        <h3>AgroRed</h3>
                        <p>
                            Conectamos productores y consumidores,
                            creando oportunidades para todos.
                        </p>
                    </div>

                    <div className="columna-footer">
                        <h4>Navegación</h4>
                        <ul>
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Productos</a></li>
                            <li><a href="#">Noticias</a></li>
                            <li><a href="#">Mejoras</a></li>
                        </ul>
                    </div>

                    <div className="columna-footer">
                        <h4>Soporte</h4>
                        <ul>
                            <li><a href="#">Ayuda</a></li>
                            <li><a href="#">Contacto</a></li>
                            <li><a href="#">Política de privacidad</a></li>
                        </ul>
                    </div>

                </div>

                <div className="copyright-footer">
                    © 2026 AgroRed. Todos los derechos reservados.
                </div>

            </footer>
        </>
    );
}

export default RegistrarProducto;
