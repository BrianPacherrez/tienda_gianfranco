<?php include '../../Controllers/cliente/editar.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="py-3">
    <main class="container contenedor">
        <div class="p-3 rounded">
            <div class="row">
                <div class="col">
                    <h4>Editar usuario</h4>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form class="row g-3" method="POST" action="guardarView.php" autocomplete="off">
                        <input type="hidden" id="cod_cliente" name="cod_cliente" value="<?php echo $cod_cliente; ?>">
                        <div class="col-md-4">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" id="nombres" name="nombres" class="form-control"
                            value="<?php echo $row['nombres']; ?>" required autofocus>
                        </div>

                        <div class="col-md-4">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" id="apellidos" name="apellidos" class="form-control"
                            value="<?php echo $row['apellidos']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="number" id="dni" name="dni" class="form-control"
                            value="<?php echo $row['dni']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="number" id="celular" name="celular" class="form-control" 
                            value="<?php echo $row['celular']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" id="usuario" name="usuario" value="<?php echo $row['usuario']; ?>"
                            class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="text" id="contraseña" name="contraseña" value="<?php echo $row['contraseña']; ?>"
                            class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="cargo">cargo:</label>
                            <select id="cargo" name="tipo_usuario" class="form-control mb-3" required>
                                <option value="">Seleccione una categoría</option>
                                    <?php foreach ($cargos as $cargo): ?>
                                    <?php $selected = ($cargo['id'] == $row['tipo_usuario']) ? 'selected' : ''; ?>
                                <option value="<?php echo $cargo['id']; ?>" <?php echo $selected; ?>><?php echo $cargo['rol']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <a href="/Views/dashboard/usuarios.php" class="btn btn-secondary">Regresar</a>
                            <button type="submit" class="btn btn-primary" name="registro">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>