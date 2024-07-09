<?php 
    include '../../Controllers/producto/editar.php';

    session_start();

    // Verificar si el usuario ha iniciado sesión
  
  
    if (!isset($_SESSION['usuario'])) {
        // Si no ha iniciado sesión, redirigir a la página de inicio de sesión y mostrar un mensaje de alerta
        echo "<script>alert('Debes iniciar sesión para acceder a tu cuenta.'); window.location.href='/login.php';</script>";
        exit();
      header('Location: ../login.php');
  
    }
  
    $rol = $_SESSION['rol'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $usuario = $_SESSION['usuario'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="/css/estilos_dashboard.css" rel="stylesheet">
    <link href="/css/estilos_tabla.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
<body class="sb-nav-fixed">


<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html"><?php echo $rol ?></a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Configuración</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="login.html">Salir</a>
                </div>
            </li>
        </ul>
    </nav>
    
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Panel</div>
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Configuración</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
                        aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                        Administrar
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="usuarios.php">Usuarios</a>
                            <a class="nav-link" href="productos.php">Productos</a>
                        </nav>
                        </div>
                        <a class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-donate"></i></div>
                        Ventas
                        </a>
                        
                        <div class="sb-sidenav-menu-heading">Interfaz</div>
                        <a class="nav-link" href="graficos.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Gráficos
                        </a>
                        <a class="nav-link" href="tablas.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Tablas
                        </a>

                        <a class="nav-link mt-3" href="../logout.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-power-off"></i></div>
                        Cerrar sesión
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado como:</div>
                    <?php echo $rol ?>
                </div>
            </nav>
        </div>



    <div id="layoutSidenav_content">
        <main">
            <div class="container-fluid">
                
                    <div class="mt-4">
                        <h1>Editar producto</h1>
                    </div>
                

                <div class="card mb-4">
                    <div class="card-header pt-4">
                            
                    </div>

                    <div class="card-body">
                        <form class="row g-3" method="POST" action="guardarView.php" autocomplete="off">
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control"
                                value="<?php echo $row['nombre']; ?>" required autofocus>
                            </div>

                            <div class="col-md-4">
                                <label for="precio_unitario" class="form-label">Precio unitario</label>
                                <input type="text" id="precio_unitario" name="precio_unitario" class="form-control" 
                                value="<?php echo $row['precio_unitario']; ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label for="stock_disponible" class="form-label">Stock disponible</label>
                                <input type="numbrer" id="stock_disponible" name="stock_disponible" value="<?php echo $row['stock_disponible']; ?>"
                                class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="categoria">Categoría:</label>
                                <select id="categoria" name="categoria_id" class="form-control mb-3" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <?php $selected = ($categoria['id'] == $row['categoria_id']) ? 'selected' : ''; ?>
                                        <option value="<?php echo $categoria['id']; ?>" <?php echo $selected; ?>><?php echo $categoria['nombre_cat']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <a href="/Views/dashboard/productos.php" class="btn btn-secondary">Regresar</a>
                                <button type="submit" class="btn btn-primary" name="registro">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>    
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    
    <!-- Desplazamiento Navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <!-- Side navigation -->
    <script src="js/scripts.js"></script>

</body>
</html>