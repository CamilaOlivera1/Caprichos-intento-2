<?php
session_start(); // Iniciar la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caprichos</title>
    <link rel="icon" href="imagenes/favicon.jpg" type="image/png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="menu container">
            <img class="logo-1" src="imagenes/logo caprichos.jpg" alt="Logo">
            
            <!-- Barra de búsqueda -->
           <!-- <div class="search-bar">
                <input type="text" placeholder="¿Qué estás buscando?" />
                <button type="submit"><img src="imagenes/lupa.png" alt="Buscar"></button>
            </div>-->

            <!-- Navegación de usuario -->
            <nav>
                <ul class="nav-menu">
                <div class="user-menu">
    <img src="imagenes/usuario.png" alt="Usuario" class="user-icon">
    <div class="dropdown-menu">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="php/perfil.php" id="perfil-link">Mi Perfil</a>
            <a href="php/cerrarSesion.php">Cerrar Sesión</a>
        <?php else: ?>
            <a href="php/inicioSesion.php" id="login-link">Inicio de Sesión</a>
            <a href="php/registrarUsuario.php" id="register-link">Registrarme</a>
        <?php endif; ?>
    </div>
</div>

<div id="carrito">
    <a href="php/carrito.php">
        <img src="imagenes/carrito compras.png" alt="Carrito" class="carrito-icon">
    </a>
</div>

                </ul>
            </nav>
        </div>
    </header>

    <!-- Menú principal -->
    <nav class="menu">
        <ul>
            <!-- Inicio -->
            <li><a href="index.php">Inicio</a></li>
            
            <!-- Productos con submenús -->
            <li>
                <a href="productos.html"> Productos <span class="arrow">&#9662;</span></a>
                <ul class="submenu">
                    <li><a href="php/productos.php?categoria=Caprichos%20Women">Caprichos Women</a></li>
                    <li><a href="php/productos.php?categoria=Caprichos%20Men">Caprichos Men</a></li>
                    <li>
                        <a href="caprichos-children.html">Caprichos Children</a>
                        <ul class="sub-submenu">
                            <li><a href="php/productos.php?categoria=Caprichos%20Children">Niños</a></li>
                            <li><a href="php/productos.php?categoria=Caprichos%20Children">Niñas</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <!-- Contacto -->
            <li><a href="#footer">Contacto</a></li>

        </ul>
    </nav>

    <section class="carousel">
        <!-- Carrusel de imágenes -->
        <div class="carousel">
    <div class="carousel-images">
        <img src="imagenes/Logo un poco mas grande.jpg" alt="Imagen 1">
        <img src="imagenes/rojo.jpg" alt="Imagen 2">
        <img src="imagenes/rallas port.jpg" alt="Imagen 3">
        <img src="imagenes/image.jpg" alt="Imagen 4">
    </div>
</div>
    </section>

    <section class="informacion-container">
        <div class="informacion-content">
            <div class="informacion-1">
                <img src="imagenes/envio.png" alt="Envio">
                <h3>Envios</h3>
                <p>Hacemos envíos con mucho cariño a los departamentos de Junín, Rivadavia y San Martín para que tus compras lleguen perfectas hasta tu puerta</p>
            </div>

            <div class="informacion-1">
                <img src="imagenes/devoluciones.png" alt="No Devoluciones">
                <h3>No hay devoluciones</h3>
                <p>No aceptamos devoluciones, pero nuestro equipo estará disponible para ayudarte si tienes algún problema</p>
            </div>
        </div>
    </section>

    <section class="categorias">
        <!-- Categorías -->
        <div class="categorias-container">
        <a href="php/productos.php?categoria=Caprichos%20Women" class="card">
           <!-- <a href="caprichos-women.html" class="card">-->
                <img src="imagenes/women.jpg" alt="Caprichos Women">
                <div class="card-text">Caprichos Woman</div>
            </a>

            <<a href="php/productos.php?categoria=Caprichos%20Men" class="card">
                <img src="imagenes/men.jpg" alt="Caprichos Men">
                <div class="card-text">Caprichos Men</div>
            </a>

            <a href="php/productos.php?categoria=Caprichos%20Children" class="card">
                <img src="imagenes/children.jpg" alt="Caprichos Children">
                <div class="card-text">Caprichos Children</div>
            </a>
        </div>
    </section>

    <!--<section class="ofertas-container">
        <h2 class="ofertas-titulo">Ofertas</h2>
        <div class="productos-grid">
             Producto 1 
            <div class="producto">
                <img src="imagenes/vestido verde.jpg" alt="Vestido">
                <h3>Vestido</h3>
                <p class="precio">$35.000</p>
            </div>
             Producto 2
            <div class="producto">
                <img src="imagenes/remera blanca hom.jpg" alt="Remera deportiva">
                <h3>Remera deportiva</h3>
                <p class="precio">$15.000</p>
            </div>
            <div class="producto">
                <img src="imagenes/remera niña.jpg" alt="Remera infantil">
                <h3>Remera Infantil</h3>
                <p class="precio">$8.000</p>
            </div>

            <div class="producto">
                <img src="imagenes/remera negra.jpg" alt="Remera Mujer">
                <h3>Remera Mujer</h3>
                <p class="precio">$16.000</p>
            </div>
        </div>
    </section>

    <section class="newsletter">
        <h3>NEWSLETTER</h3>
        <h2>Actualiza Tu Guardarropa con Nuestra Selección de Moda</h2>
        <p>¿Querés recibir nuestras ofertas? ¡Registrate ya mismo y comenzá a disfrutarlas!</p>
        <form action="suscripcion.php" method="POST">
            <input type="email" placeholder="Email" name="email" required>
            <button type="submit">
                <span>&#x27A4;</span>
            </button>
        </form>
    </section>-->

    <!-- Pie de página -->

    <footer id="footer" class="footer">
        <div class="footer-section">
            <h2>Sobre Nosotros</h2>
            <p>Somos "Caprichos" nos especializamos en la venta de indumentaria de alta calidad para mujeres, hombres y niños, fusionando moda y funcionalidad para satisfacer las exigencias de nuestros clientes.</p>
        </div>
        <div class="footer-section">
            <h2>Medios de pago</h2>
            <p>Tarjeta de Crédito y Tarjeta de Débito</p>
            <!--<img src="visa.png" alt="Visa">
            <img src="mastercard.png" alt="MasterCard">-->
        </div>
        <div class="footer-section">
            <h2>Redes Sociales</h2>
            <p><a href="https://www.facebook.com/groups/3033189253417410/?ref=share&mibextid=NSMWBT">Facebook</a> </p> 
           <P> <a href="https://www.instagram.com/caprichos_women?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Instagram Woman</a> | <a href="https://www.instagram.com/caprichos_men?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Instagram Men</a> | <a href="https://www.instagram.com/caprichos_children?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Instagram Children</a> </p>
        </div>
        <p>&copy; 2024 Tu Tienda Online. Todos los derechos reservados.</p>
       </footer>

    <!-- Scripts -->
    <script src="js/script.js"></script>
</body>
</html>
