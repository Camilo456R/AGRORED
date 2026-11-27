import { Link } from 'react-router-dom';
import '../css/style.css';
import logo from '../img/Logo_letras.png';
import imgUsuario from '../img/Znahoria.png';
import imgPedido from '../img/Mandarina.png';
import imgArticulos from '../img/Maiz.png';
import imgPapa from '../img/Papas.png';


function Inicio() {
    return (
        <div>
        {/* Navbar */}
        <nav>
            <div className="Navbar">
            <Link to="/" className="logo-link">
                <img src={logo} alt="AgroRed" width="30%" className="imagen_logo" />
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

        {/* Banner */}
        <div className="banner-verde">
            <div className="contenido-banner">
            <h1>AGRORED</h1>
            <p>Directo del campo a tu casa</p>
            </div>
        </div>

        {/* Tarjetas con los enlaces */}
        <section className="seccion-categorias">
            <div className="titulo-categorias">
                <h2>Categorías</h2>
                <p>Tú también puedes ayudar, llena el formulario y empieza a vender</p>
                </div>
                <div className="tarjetas-grid">
                <div className="tarjeta">
                    <img src={imgUsuario} alt="Usuarios" />
                    <h3>Verduras</h3>
                    <p>Frescas y orgánicas</p>
                </div>

                <div className="tarjeta">
                    <img src={imgPedido} alt="Pedidos" />
                    <h3>Frutas</h3>
                    <p>De temporada</p>
                </div>

                <div className="tarjeta">
                    <img src={imgArticulos} alt="Artículos" />
                    <h3>Granos</h3>
                <p>100% naturales</p>
                </div>

                <div class="tarjeta">
                    <img src={imgPapa} alt="Papas"/>
                    <h3>Papas</h3>
                    <p>De primera calidad</p>
                </div>
            </div>
        </section>



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

export default Inicio;