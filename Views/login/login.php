<?php
    require('../../Model/database.php');
    session_start();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Crear una instancia de la clase Database
        $db = new Database();
        $con = $db->conectar();
        
        // Escapar las entradas del formulario
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        
        // Consultar la base de datos para encontrar al usuario
        $sql = "SELECT * FROM clientes WHERE usuario = :usuario";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            if ($result['contraseña'] == $contraseña) {
                // Obtener el tipo_usuario del resultado
                $tipo_usuario = $result['tipo_usuario'];
                
                // Consultar la tabla cargo para obtener el rol correspondiente
                $sql_cargo = "SELECT rol FROM cargos WHERE id = :tipo_usuario";
                $stmt_cargo = $con->prepare($sql_cargo);
                $stmt_cargo->bindParam(':tipo_usuario', $tipo_usuario, PDO::PARAM_INT);
                $stmt_cargo->execute();
                $result_cargo = $stmt_cargo->fetch(PDO::FETCH_ASSOC);
                
                if ($result_cargo) {
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['rol'] = $result_cargo['rol'];
                    $_SESSION['tipo_usuario'] = $tipo_usuario;
                    // header("Location: ../Views/cuenta.php");
                    header("Location: /Views/dashboard/dashboard.php");
                    exit();
                } else {
                    $error = "Error al obtener el rol del usuario.";
                }
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap Font-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    <!--Google Font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Style Font-->
    <link rel="stylesheet" href="/css/estilos_login.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/assets/js/functions.js"></script>

    <title>Tienda de Abarrotes "Gian Franco"</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Iniciar sesión</a>
                <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Gian Franco</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/cuenta.php">Mi cuenta</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Más información
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="#">Dirección y ubicación de la tienda</a></li>
                                    <li><a class="dropdown-item" href="#">Horario de atención</a></li>
                                    <li>
                                    <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Número de contacto</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex mt-3" role="search">
                            <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                            <button class="btn btn-success" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Circulos -->
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Login -->
    <div class="contenedor">
        <h2>Login!
            <span>Ingrese a su cuenta.</span>
        </h2>
        
            <form action="login.php" id="forma" name="forma" method="post">
                <div class="elemento">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Ingresa tu nombre de usuario" required>
                </div>

                <div class="elemento">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" name="contraseña" id="contraseña" placeholder="Ingresa tu contraseña" required>
                </div>

                <div class="elemento">
                    <input type="submit" value="Ingresar" class="enviar">
                </div>
            </form>

        <div class="registrate">
          ¿Aún no tienes cuenta? <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Regístrate</a>
        </div>
    </div>

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
                    <form action="/Controllers/cliente/registrar.php" method="post">
                        <input type="hidden" class="form-control mb-3" name="cod_cliente" placeholder="Cod cliente" required>
                        <input type="text" class="form-control mb-3" name="nombres" placeholder="Ingresa tu nombre" required>
                        <input type="text" class="form-control mb-3" name="apellidos" placeholder="Ingresa tu apellido" required>
                        <input type="number" class="form-control mb-3" name="dni" placeholder="Ingresa tu DNI" required>
                        <input type="number" class="form-control mb-3" name="celular" placeholder="Ingresa tu Número de celular" required>
                        <input type="text" class="form-control mb-3" name="usuario" placeholder="Ingresa tu usuario" required>
                        <input type="text" class="form-control mb-3" name="contraseña" placeholder="Ingresa tu contraseña" required>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <input type="submit" class="btn btn-primary" onclick="exito(event)" value="Enviar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exito(event) {
            event.preventDefault(); 
            swal({
                title: "¡Buen trabajo!",
                text: "Datos enviados correctamente.",
                icon: "success",
                button: "¡Genial!",
            })
            .then(() => {
                event.target.form.submit(); 
            });
        }

    </script>

    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>

    <?php 
    if (!empty($error)) {
        echo "<script>showAlert('$error');</script>";
    }
    ?>

    <!-- Script JS bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>