import { Link } from 'react-router-dom';
import '../css/style.css';
import logo from '../img/Logo_letras.png';
import imgUsuarios from '../img/Znahoria.png';
import imgProductos from '../img/Mandarina.png';
import imgFacturas from '../img/Maiz.png';


function MenuAdmin() {
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

        {/* Banner */}
        <div className="banner-verde">
            <div className="contenido-banner">
            <h1>AGRORED</h1>
            <p>Menu administrador</p>
            </div>
        </div>

        {/* Contenidos */}
        <section className="seccion-categorias">
            <div className="titulo-categorias">
            <h2>Modificables</h2>
            <p>Solo los administradores pueden acceder aquí</p>
            </div>

            <div className="tarjetas-grid">
            <div className="tarjeta">
                <img src={imgUsuarios} alt="Usuarios" />
                <h3>CRUD Usuarios</h3>
                <a href="#">IR</a>
            </div>

            <div className="tarjeta">
                <img src={imgProductos} alt="Productos" />
                <h3>Listado Productos</h3>
                <a href="#">IR</a>
            </div>

            <div className="tarjeta">
                <img src={imgFacturas} alt="Facturas" />
                <h3>Listado facturas</h3>
                <a href="#">IR</a>
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

export default MenuAdmin;