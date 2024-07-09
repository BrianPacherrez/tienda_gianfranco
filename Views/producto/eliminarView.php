<?php include '../../Controllers/producto/eliminar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/estilos.css">
    <script src="../public/js/bootstrap.bundle.min.js"></script>
</head>
<body class="py-3">
    <main class="container contenedor">
        <div class="p-3 rounded">
            <div class="row">
                <div class="col">
                    <?php if ($numEliminar > 0) { ?>
                        <h3>Producto eliminado</h3>
                    <?php } else { ?>
                        <h3>Error al eliminar producto</h3>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <a href="../Views/index.php" class="btn btn-primary">Regresar</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>