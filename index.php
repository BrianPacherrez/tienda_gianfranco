<?php
    session_start();
    require 'Model/database.php';

    // Crear instancia de la clase Database
    $db = new Database();
    $con = $db->conectar();

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Trocchi&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- SweetAlert Script-->
    <script src="/path/to/alerts.js"></script>
    
    <link rel="stylesheet" href="/css/estilos_index.css">
    <title>Tienda de Abarrotes "Gian Franco"</title>
</head>
<body>
    <header>
        <a class="logo" href="#">GIAN FRANCO</a>
        <ul class="ul_contador">
            <li><i class="bi bi-info-square icono-nav"></i> Informacion</li>
            <li class="iniciar-sesion"> <i class="bi bi-person-circle icono-nav"></i> Hola, Inicia sesión
                <ul class="ul-segundo">
                    <li><a href="/Views/login/login.php">Iniciar sesión</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Regístrate</a></li>
                    <li><a href="/Views/dashboard/dashboard.php">Mi cuenta</a></li>
                </ul>
            </li>
            <li><a class="icono" href="/Views/carrito/cart.php"><i class="bi bi-cart icono-nav"></i> Mis compras</li></a>
            <li><a class="icono" href="../../index.php#contacto"><i class="bi bi-telephone icono-nav"></i> Contacto</a></li>
        </ul>
    </header>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="4000">
                <img src="/img/productos_panel/cebolla.jpg" class="d-block w-100" alt="..." style="width: 100%; height: 350px; object-fit: cover;">
            </div>

            <div class="carousel-item" data-bs-interval="3000">
                <img src="/img/productos_panel/papa.jpg" class="d-block w-100" alt="..." style="width: 100%; height: 350px; object-fit: cover;">
            </div>

            <div class="carousel-item" data-bs-interval="3000">
                <img src="/img/productos_panel/coca_cola.jpg" class="d-block w-100" alt="..." style="width: 100%; height: 350px; object-fit: cover;">
            </div>

            <div class="carousel-item" data-bs-interval="3000">
                <img src="/img/productos_panel/snickers.jpg" class="d-block w-100" alt="..." style="width: 100%; height: 350px; object-fit: cover;">
            </div>

            <div class="carousel-item">
                <img src="/img/productos_panel/colgate.jpg" class="d-block w-100" alt="..." style="width: 100%; height: 350px; object-fit: cover;">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="titulo-categorias">
        Nuestras Categorías
    </div>
      
    <div class="contenedor-categorias">
        <div class="item-categoria">
            <figure>
                <img src="/img/productos_catálogo/aceite.png" alt="...">
            </figure>
            <div class="info-categoria">
                <h4>Alimentos básicos</h4>
            </div>
        </div>

        <div class="item-categoria">
            <figure>
                <img src="/img/bebidas.png" alt="...">
            </figure>
            <div class="info-categoria">
                <h4>Bebidas</h4>
            </div>
        </div>

        <div class="item-categoria">
            <figure>
                <img src="/img/snacks.jpeg" alt="...">
            </figure>
            <div class="info-categoria">
                <h4>Snacks y golosinas</h4>
            </div>
        </div>

        <div class="item-categoria">
            <figure>
                <img src="/img/limpieza.png" alt="...">
            </figure>
            <div class="info-categoria">
                <h4>Limpieza</h4>
            </div>
        </div>

        <div class="item-categoria">
            <figure>
                <img src="/img/cuidado_personal.jpg" alt="...">
            </figure>
            <div class="info-categoria">
                <h4>Cuidado personal</h4>
            </div>
        </div>
    </div>


    <!-- Productos -->
    <div class="container-items">
        <?php

        $comando = $con->prepare("SELECT * FROM mis_productos ORDER BY id");
        $comando->execute();
        $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

        if (count($resultado) > 0) {
            foreach ($resultado as $row) {
                ?>
                <div class="item">
                    <figure>
                        <img src="/img/productos_catálogo/<?php echo $row['image']; ?>" alt="producto" />
                    </figure>
                    <div class="info-product">
                        <h2><?php echo $row["producto"]; ?></h2>
                        <p class="price"><?php echo 'S/.' . $row["precio_unitario"]; ?></p>
                        <button class="boton-producto" onclick="addToCart(<?php echo $row['id']; ?>)">Añadir al carrito</button>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No hay resultados";
        }
        ?>
    </div>

    <script>
        function addToCart(productId) {
            // Hacer una solicitud AJAX para añadir el producto al carrito
            fetch('/Views/carrito/AccionCarta.php?action=addToCart&id=' + productId)
                .then(response => response.json())
                .then(data => {
                    // Actualizar el contador del carrito
                    document.getElementById('cart-count').textContent = data.cartCount;
                    showSuccessAlert('Producto añadido al carrito exitosamente!');
                })
                .catch(error => console.error('Error:', error));
                showErrorAlert('Hubo un error al añadir el producto al carrito.');
        }
    </script>

    <div class="logo-carrito">
        <a href="/Views/carrito/cart.php"><i class="bi bi-cart icono-nav"></i></a>
        <span id="cart-count">
            <?php echo array_sum($_SESSION['cart']); ?>
        </span>
    </div>

    <footer id="contacto">
        <div class="contenedor-pie-pagina">
            <div class="grupo-1">
                <div class="box">
                    <figure>
                        <a href="#"><img src="/img/logo.png" alt="Icono Tienda"></a>
                    </figure>
                </div>
            </div>

            <div class="box">
                <h1>Sobre nosotros</h1>
                <p>Ofrecemos una amplia gama de productos y servicios para satisfacer las necesidades diarias de los clientes. </p>
            </div>

            <div class="box">
                <h2>Dirección</h2>
                <div class="contacto">
                    <a href="#"><i class="bi bi-house-door icono-footer"></i> Jr. 3 de Febrero 1281, La Victoria - Lima</a>
                    <br>
                    <a href="#"><i class="bi bi-phone icono-footer"></i> 325-55-28</a>
                    <br>
                    <a href="#"><i class="bi bi-telephone-plus icono-footer"></i> 942472012</a>
                </div>
            </div>
        </div>

        <div class="grupo-2">
            <small>&copy; 2024 <b>Gian Franco</b> - Todos los derechos son reservados</small>
        </div>
    </footer>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2" id="exampleModalLabel">Regístrate</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal Formulario-->
                <form id="registroForm" action="/Controllers/cliente/registrar.php" method="post">
                    <input type="hidden" class="form-control mb-3" name="cod_cliente" placeholder="Cod cliente" required>
                    <input type="text" class="form-control mb-3" name="nombres" placeholder="Ingresa tu nombre" required>
                    <input type="text" class="form-control mb-3" name="apellidos" placeholder="Ingresa tu apellido" required>
                    <input type="text" class="form-control mb-3" name="dni" placeholder="Ingresa tu DNI" required>
                    <input type="text" class="form-control mb-3" name="celular" placeholder="Ingresa tu Número de celular" required>
                    <input type="text" class="form-control mb-3" name="usuario" placeholder="Ingresa tu usuario" required>
                    <input type="password" class="form-control mb-3" name="contraseña" placeholder="Ingresa tu contraseña" required>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Script JS bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/assets/js/functions.js"></script>

</body>
</html>