
import React from "react";
import Swal from "sweetalert2";

import "../static/css/productos.css";

// Imágenes
import logoLetras from "../static/img/Logo_letras.png";
import zanahoriaIcono from "../static/img/Znahoria.png";
import zanahorias from "../static/img/Zanahorias.png";
import tomates from "../static/img/Tomates_cherry.png";
import pimentones from "../static/img/Pimentones.png";
import mandarina from "../static/img/Mandarina.png";
import manzana from "../static/img/Manzana.png";
import pera from "../static/img/Pera.png";
import maiz from "../static/img/Maiz.png";
import mazorca from "../static/img/Mazorca.png";

function Productos() {

    // Mensaje al agregar un producto
    const productoAgregado = (nombre) => {
        Swal.fire({
            title: "¡Producto agregado!",
            text: `${nombre} fue agregado correctamente.`,
            icon: "success",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#12DA00"
        });
    };

    return (
        <>
            {/* NAVBAR */}
            <nav>
                <div className="Navbar">

                    <a href="/" className="logo-link">
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
                        placeholder="Arroz"
                    />

                    <div className="botones">
                        <a href="#">
                            <input
                                type="button"
                                value="Iniciar"
                                className="Iniciar"
                            />
                        </a>

                        <a href="#">
                            <input
                                type="button"
                                value="Registrarse"
                                className="Registrarse"
                            />
                        </a>
                    </div>

                </div>
            </nav>

            {/* CONTENIDO PRINCIPAL */}
            <section className="seccion-categorias">

                <div className="titulo-categorias">
                    <h2>Productos</h2>
                    <p>
                        Disfruta de una cantidad enorme de Frutas,
                        Verduras y Granos a tu disposición
                    </p>
                </div>

                {/* CATEGORÍA VERDURAS */}
                <div className="icono-categorias">
                    <img
                        src={zanahoriaIcono}
                        alt="Icono verduras"
                        className="icono"
                    />

                    <div className="Texto_icono_categorias">
                        <h2>Verduras</h2>
                        <span>Frescas y orgánicas</span>
                    </div>
                </div>

                {/* TARJETAS VERDURAS */}
                <div className="tarjetas-grid">

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img src={zanahorias} alt="Zanahorias" />
                            <span className="etiqueta">Orgánico</span>
                        </div>

                        <div className="info-tarjeta">
                            <h3>Zanahorias</h3>
                            <p>Cultivadas sin pesticidas</p>

                            <div className="pie-tarjeta">
                                <h2>$2.50 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Zanahorias")}
                                />
                            </div>
                        </div>
                    </div>

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img src={tomates} alt="Tomates Cherry" />
                            <span className="etiqueta">Oferta</span>
                        </div>

                        <div className="info-tarjeta">
                            <h3>Tomates Cherry</h3>
                            <p>Frescos y jugosos para toda la familia</p>

                            <div className="pie-tarjeta">
                                <h2>$3.00 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Tomates Cherry")}
                                />
                            </div>
                        </div>
                    </div>

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img src={pimentones} alt="Pimentones" />
                        </div>

                        <div className="info-tarjeta">
                            <h3>Pimentones Variados</h3>
                            <p>En todos sus estados</p>

                            <div className="pie-tarjeta">
                                <h2>$2.00 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Pimentones Variados")}
                                />
                            </div>
                        </div>
                    </div>

                </div>

                {/* CATEGORÍA FRUTAS */}
                <div className="icono-categorias">
                    <img
                        src={mandarina}
                        alt="Icono frutas"
                        className="icono"
                    />

                    <div className="Texto_icono_categorias">
                        <h2>Frutas</h2>
                        <span>Frescas y orgánicas</span>
                    </div>
                </div>

                {/* TARJETAS FRUTAS */}
                <div className="tarjetas-grid">

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img src={manzana} alt="Manzana" />
                        </div>

                        <div className="info-tarjeta">
                            <h3>Manzana</h3>
                            <p>Fresca y crujiente</p>

                            <div className="pie-tarjeta">
                                <h2>$2.50 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Manzana")}
                                />
                            </div>
                        </div>
                    </div>

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_rCxF-zyhwLLo8R2UvNzG92hc1fXX-mZ62axoYxnV7GfbAWtD3Prfl5mJlcyYNrKsRjDrSHUR-tbnCckGuvZfGSVlYDmX7DquP-cVGg&s=10"
                                alt="Piña"
                            />
                        </div>

                        <div className="info-tarjeta">
                            <h3>Piña</h3>
                            <p>Dulce y jugosa</p>

                            <div className="pie-tarjeta">
                                <h2>$3.00 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Piña")}
                                />
                            </div>
                        </div>
                    </div>

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img src={pera} alt="Pera" />
                            <span className="etiqueta">Oferta</span>
                        </div>

                        <div className="info-tarjeta">
                            <h3>Pera</h3>
                            <p>Fresca y crujiente</p>

                            <div className="pie-tarjeta">
                                <h2>$2.50 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Pera")}
                                />
                            </div>
                        </div>
                    </div>

                </div>

                {/* CATEGORÍA GRANOS */}
                <div className="icono-categorias">
                    <img
                        src={maiz}
                        alt="Icono granos"
                        className="icono"
                    />

                    <div className="Texto_icono_categorias">
                        <h2>Granos</h2>
                        <span>Nutritivos y bien valorados</span>
                    </div>
                </div>

                {/* TARJETAS GRANOS */}
                <div className="tarjetas-grid">

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img src={mazorca} alt="Mazorca" />
                            <span className="etiqueta">Último</span>
                        </div>

                        <div className="info-tarjeta">
                            <h3>Mazorca</h3>
                            <p>Fresca y crujiente</p>

                            <div className="pie-tarjeta">
                                <h2>$2.50 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Mazorca")}
                                />
                            </div>
                        </div>
                    </div>

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img
                                src="https://www.cocinista.es/download/bancorecursos/ingredientes/ingrediente-frijoles-mexicanos.jpg"
                                alt="Frijoles"
                            />
                        </div>

                        <div className="info-tarjeta">
                            <h3>Frijoles</h3>
                            <p>Cuidadosamente seleccionados</p>

                            <div className="pie-tarjeta">
                                <h2>$3.00 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Frijoles")}
                                />
                            </div>
                        </div>
                    </div>

                    <div className="tarjeta">
                        <div className="imagen-contenedor">
                            <img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSz8LMAyBiJ3vW6oUnJJYU1Usvg4UWXNCtIgHeJsJ4gaw&s=10"
                                alt="Lentejas"
                            />
                            <span className="etiqueta">Oferta</span>
                        </div>

                        <div className="info-tarjeta">
                            <h3>Lentejas</h3>
                            <p>Cuidadosamente seleccionadas</p>

                            <div className="pie-tarjeta">
                                <h2>$2.50 Lb</h2>
                                <input
                                    type="button"
                                    value="Agregar"
                                    className="boton-comprar"
                                    onClick={() => productoAgregado("Lentejas")}
                                />
                            </div>
                        </div>
                    </div>

                </div>

            </section>

            {/* FOOTER */}
            <footer className="pie-pagina">

                <div className="contenedor-footer">

                    <div className="columna-footer">
                        <h3>AGRORED</h3>
                        <p>
                            Conectando el campo con tu mesa.
                            Llena el formulario y empieza a vender
                            o comprar productos frescos de la mejor calidad.
                        </p>
                    </div>

                    <div className="columna-footer">
                        <h4>Navegación</h4>
                        <ul>
                            <li><a href="#">Productos</a></li>
                            <li><a href="#">Noticias</a></li>
                            <li><a href="#">Mejoras</a></li>
                            <li><a href="#">Categorías</a></li>
                        </ul>
                    </div>

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

                <div className="copyright-footer">
                    <p>© 2026 AGRORED. Todos los derechos reservados.</p>
                </div>

            </footer>
        </>
    );
}

export default Productos;
