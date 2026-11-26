import { Link } from 'react-router-dom';
import { ChevronDown } from 'lucide-react';
import '../css/style.css';
import '../css/envio.css';
import logo from '../img/Logo_letras.png';


function Envio() {
    return (
        <div>
        {/* Navbar */}
        <nav>
            <div className="Navbar">
            <Link to="/" className="logo-link">
                <img src={logo} alt="AgroRed" className="imagen_logo" />
            </Link>
            <Link to="/articulos">Productos</Link>
            <a href="#">Noticias</a>
            <a href="#">Mejoras</a>
            <input type="search" placeholder="Arroz" />

            <div className="botones">
                <a href="#">
                <input type="button" value="Iniciar" className="Iniciar" />
                </a>
                <a href="#">
                <input type="button" value="Registrarse" className="Registrarse" />
                </a>
            </div>
            </div>
        </nav>

        {/* CONTENIDO PRINCIPAL */}
        <main className="main-wrapper">
            <h1 className="page-title">Envío</h1>

            <div className="gray-container">

            <div className="banner-header">
                AHORA HASTA TU<br />CASA
            </div>

            <div className="checkout-card">

                {/* SECCIÓN IZQUIERDA: DETALLES DE ENVÍO */}
                <section className="shipping-section">
                <h2>Detalles de Envío</h2>

                <form className="shipping-form">
                    <div className="form-row">
                    <input type="text" placeholder="Primer nombre" />
                    <input type="text" placeholder="Apellido" />
                    </div>

                    <input type="text" placeholder="Dirección" />

                    <input type="text" placeholder="Dirección 2 (opcional)" />

                    <div className="form-row">
                    <div className="select-wrapper">
                        <select required defaultValue="">
                        <option value="" disabled hidden>Departamento</option>
                        <option value="cundinamarca">Cundinamarca</option>
                        <option value="antioquia">Antioquia</option>
                        </select>
                        <ChevronDown className="select-icon" />
                    </div>
                    <input type="text" placeholder="Municipio" />
                    </div>

                    <div className="form-row">
                    <input type="text" placeholder="Código postal" />
                    <input type="text" placeholder="Número de teléfono" />
                    </div>

                    <div className="shipping-options">
                    <label className="shipping-card-option selected">
                        <input type="radio" name="shipping_method" defaultChecked />
                        <div className="option-text">
                        <strong>Envío Gratuito</strong>
                        <span>Entre 2-5 días laborables</span>
                        </div>
                    </label>

                    <label className="shipping-card-option">
                        <input type="radio" name="shipping_method" />
                        <div className="option-text">
                        <strong>Entrega al día siguiente - $2.50</strong>
                        <span>24 horas desde el pago</span>
                        </div>
                    </label>
                    </div>

                    <div className="action-buttons">
                    <button type="submit" className="btn-pay">Continuar Envío</button>
                    <button type="button" className="btn-cancel">Cancelar</button>
                    </div>
                </form>
                </section>

                {/* SECCIÓN DERECHA: RESUMEN DE COMPRA */}
                <aside className="summary-section">
                <h2>Resumen</h2>

                <div className="cart-items-list">
                    <div className="cart-item">
                    <img src="https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?auto=format&fit=crop&w=150&q=80" alt="Manzana" />
                    <div className="item-details">
                        <h3>MANZANA 'HONEYCRISP'</h3>
                        <p>Manzana dulce y crujiente.</p>
                    </div>
                    <span className="item-price">$1.50</span>
                    </div>

                    <div className="cart-item">
                    <img src="https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=150&q=80" alt="Pera" />
                    <div className="item-details">
                        <h3>PERA ANJOU</h3>
                        <p>Fruta suave y dulce.</p>
                    </div>
                    <span className="item-price">$2.00</span>
                    </div>

                    <div className="cart-item">
                    <img src="https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=150&q=80" alt="Mango" />
                    <div className="item-details">
                        <h3>MANGO ATAULFO</h3>
                        <p>Mango dulce sin hebras.</p>
                    </div>
                    <span className="item-price">$3.50</span>
                    </div>

                    <div className="cart-item">
                    <img src="https://images.unsplash.com/photo-1596591606975-97ee5cef3a1e?auto=format&fit=crop&w=150&q=80" alt="Arándanos" />
                    <div className="item-details">
                        <h3>ARÁNDANOS ORGÁNICOS</h3>
                        <p>Arándanos frescos orgánicos.</p>
                    </div>
                    <span className="item-price">$4.99</span>
                    </div>
                </div>

                <div className="coupon-row">
                    <span>¿TIENES UN VALE?</span>
                    <ChevronDown />
                </div>

                <div className="summary-totals">
                    <div className="total-row">
                    <span>SUBTOTAL</span>
                    <span>$11.99</span>
                    </div>
                    <div className="total-row">
                    <span>ENVÍO</span>
                    <span>GRATIS</span>
                    </div>
                    <div className="total-row">
                    <span>IMPUESTOS (10%)</span>
                    <span>$1.20</span>
                    </div>

                    <div className="total-row final-total">
                    <strong>TOTAL</strong>
                    <strong>$13.19</strong>
                    </div>
                </div>
                </aside>

            </div>
            </div>
        </main>

        {/* Footer */}
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
            <p>&copy; 2026 AGRORED. Todos los derechos reservados.</p>
            </div>
        </footer>
        </div>
    );
}

export default Envio;