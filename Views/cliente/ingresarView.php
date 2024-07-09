<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="py-3">
    <main class="container contenedor">
        <div class="p-3 rounded">
            <div class="row">
                <div class="col">
                    <h4>Nuevo registro</h4>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form class="row g-3" method="POST" action="guardarView.php" autocomplete="off">
                        <div class="col-md-4">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" id="nombres" name="nombres" class="form-control" required autofocus>
                        </div>

                        <div class="col-md-4">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" id="apellidos" name="apellidos" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="number" id="dni" name="dni" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="number" id="celular" name="celular" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" id="usuario" name="usuario" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="text" id="contraseña" name="contraseña" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <a href="cuenta.php" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary" name="registro" required>Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!-- Script JS bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>