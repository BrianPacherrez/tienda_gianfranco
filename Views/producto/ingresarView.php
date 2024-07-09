<?php
require '../../Model/database.php';

$db = new Database();
$con = $db->conectar();

// Obtener todas las categorías disponibles para el select
$query_categorias = $con->query("SELECT id, nombre_cat FROM categorias");
$categorias = $query_categorias->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="py-3">
    <main class="container contenedor">
        <div class="p-3 rounded">
            <div class="row">
                <div class="col">
                    <h4>Nuevo producto</h4>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form class="row g-3" method="POST" action="guardarView.php" autocomplete="off">
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required autofocus>
                        </div>

                        <div class="col-md-4">
                            <label for="precio_unitario" class="form-label">Precio unitario</label>
                            <input type="text" id="precio_unitario" name="precio_unitario" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="stock_disponible" class="form-label">Stock disponible</label>
                            <input type="text" id="stock_disponible" name="stock_disponible" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="categoria">Categoría:</label>
                            <select id="categoria" name="categoria_id" class="form-control" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre_cat']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <a href="/Views//dashboard/productos.php" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary" name="registro">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>