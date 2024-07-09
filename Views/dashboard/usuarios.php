<?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    
    
    if (!isset($_SESSION['usuario'])) {
        // Si no ha iniciado sesión, redirigir a la página de inicio de sesión y mostrar un mensaje de alerta
        echo "<script>alert('Debes iniciar sesión para acceder a tu cuenta.'); window.location.href='/Views/login/login.php';</script>";
        exit();
        header('Location: ../login/login.php');
    }
    
    $rol = $_SESSION['rol'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $usuario = $_SESSION['usuario'];

    require ('../../Controllers/cliente/mostrar.php');

    // Obtener los datos de usuarios y sus roles (clientes y administradores)
    $sqlUsuarios = "SELECT COUNT(c.cod_cliente) AS total_usuarios, 
        SUM(CASE WHEN ca.rol = 'cliente' THEN 1 ELSE 0 END) AS clientes,
        SUM(CASE WHEN ca.rol = 'administrador' THEN 1 ELSE 0 END) AS administradores
        FROM clientes c
        INNER JOIN cargos ca ON c.tipo_usuario = ca.id";
    $stmtUsuarios = $con->prepare($sqlUsuarios);
    $stmtUsuarios->execute();
    $usuariosData = $stmtUsuarios->fetch(PDO::FETCH_ASSOC);

    $totalClientes = $usuariosData['clientes'];
    $totalAdministradores = $usuariosData['administradores'];


    // Obtener el cliente_id del usuario logueado
    $sqlUsuarios = "SELECT c.usuario, COUNT(dv.producto_id) AS total_productos_comprados, SUM(dv.cantidad) AS total_cantidad_comprada
        FROM clientes c
        LEFT JOIN ventas v ON c.cod_cliente = v.cliente_id
        LEFT JOIN detalles_ventas dv ON v.id = dv.venta_id
        GROUP BY c.usuario";
    $stmtUsuarios = $con->prepare($sqlUsuarios);
    $stmtUsuarios->execute();
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    $dataCompras = [];

    foreach ($usuarios as $usuario) {
        $dataCompras[] = [
            'usuario' => $usuario['usuario'],
            'total_productos' => $usuario['total_productos_comprados'],
            'total_cantidad' => $usuario['total_cantidad_comprada']
        ];
    }

    // Convertir los datos a JSON para pasarlos a JavaScript
    $dataComprasJson = json_encode($dataCompras);
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Usuarios</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
        <link href="/css/estilos_dashboard.css" rel="stylesheet">
        <link href="/css/estilos_tabla.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
</head>
<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html"><?php echo $rol ?></a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                <i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/Views/login/logout.php">Salir</a>
                </div>
            </li>
        </ul>
    </nav>
    
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
            <div class="nav">

                <?php if ($tipo_usuario == 1) { ?>

                <div class="sb-sidenav-menu-heading">Panel</div>
                <a class="nav-link" href="/Views/dashboard/dashboard.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
                </a>

                <?php } ?>

                <?php if ($tipo_usuario == 1) { ?>

                <div class="sb-sidenav-menu-heading">Interfaz</div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
                aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                Configuración
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="usuarios.php">Usuarios</a>
                    <a class="nav-link" href="productos.php">Productos</a>
                </nav>
                </div>

                <?php } ?>

                <?php if ($tipo_usuario == 2) { ?>

                <div class="sb-sidenav-menu-heading">Interfaz</div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
                aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                Configuración
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="mi_usuario.php">Usuarios</a>
                    <a class="nav-link" href="mi_producto.php">Productos</a>
                </nav>
                </div>

                <?php } ?>

                <div class="sb-sidenav-menu-heading">Sesión</div>
                <a class="nav-link" href="/index.php">
                <div class="sb-nav-link-icon"><i class="fa fa-home"></i></div>
                Inicio
                </a>
                <a class="nav-link" href="/Views/login/logout.php">
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
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Usuarios</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>

                    <!-- Tabla de gráficos -->
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header text-white">
                                        <i class="fas fa-chart-area mr-1"></i>
                                        Gráfico circular
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="300"></canvas></div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header text-white">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Gráfico de Barras
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="300"></canvas></div>
                                </div>
                            </div>
                        </div>

                    <!-- Tabla lista de usuarios -->
                    <div class="card mb-4">
                        <div class="card-header text-white bg-primary">

                            <i class="fas fa-table mr-2"></i>
                            Lista de usuarios
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mt-3" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>DNI</th>
                                            <th>Celular</th>
                                            <th>Usuario</th>
                                            <th>Contraseña</th> 
                                            <th>Rol</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($resultado as $row) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $row ['cod_cliente']?></th>
                                            <td><?php echo $row ['nombres']?></td>
                                            <td><?php echo $row ['apellidos']?></td>
                                            <td><?php echo $row ['dni']?></td>
                                            <td><?php echo $row ['celular']?></td>
                                            <td><?php echo $row ['usuario']?></td>
                                            <td><?php echo $row ['contraseña']?></td>
                                            <td><?php echo $row ['rol']?></td>
                                            <td><a href="/Views/cliente/editarView.php?id=<?php echo $row ['cod_cliente']?>" class="btn btn-info">Editar</a></td>
                                            <td><a href="/Views/cliente/eliminarView.php?id=<?php echo $row ['cod_cliente']?>" class="btn btn-danger">Eliminar</a></td>
                                        </tr>
                                        <?php 
                                            }
                                                
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>                    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    
    <!-- Desplazamiento Navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <!-- Side navigation -->
    <script src="js/scripts.js"></script>

    <script>
       const dataCompras = <?php echo $dataComprasJson; ?>;

        // Procesa los datos para el gráfico
        const usuarios = dataCompras.map(item => item.usuario);
        const totalesProductos = dataCompras.map(item => item.total_productos);

        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usuarios,
                datasets: [{
                    label: 'Total de Productos Comprados',
                    data: totalesProductos,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 90,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Total de Productos Comprados por Usuario'
                    }
                }
            }
        });

        const totalClientes = <?php echo $totalClientes; ?>;
        const totalAdministradores = <?php echo $totalAdministradores; ?>;

        const ctxPie = document.getElementById('myPieChart').getContext('2d');
        const myPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Clientes', 'Administradores'],
                datasets: [{
                    label: 'Usuarios por Tipo',
                    data: [totalClientes, totalAdministradores],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribución de Usuarios por Tipo'
                    }
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "lengthMenu": "Mostrar _MENU_ entradas por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>

    </body>
</html>