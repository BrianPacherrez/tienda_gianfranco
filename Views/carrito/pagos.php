<?php
session_start();
require '../../Model/database.php';

$db = new Database();
$con = $db->conectar();

// Obtener los productos del carrito
$cartItems = isset($_SESSION['cart']) ? array_keys($_SESSION['cart']) : array();
if (count($cartItems) > 0) {
    $ids = implode(',', array_map('intval', $cartItems));
    $sql = "SELECT * FROM productos WHERE id IN ($ids)";
    $comando = $con->prepare($sql);
    $comando->execute();
    $productos = $comando->fetchAll(PDO::FETCH_ASSOC);
} else {
    $productos = array();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesar la orden
    $cliente_id = 1; // ID del cliente (puedes obtenerlo de la sesión o de otra fuente)
    $fecha_venta = date('Y-m-d H:i:s');
    $subtotal = 0;
    $igv = 0;
    $total = 0;

    // Calcular el subtotal, igv y total
    foreach ($productos as $producto) {
        $subtotal += $_SESSION['cart'][$producto['id']] * $producto['precio_unitario'];
    }
    $igv = $subtotal * 0.18;
    $total = $subtotal + $igv;

    // Insertar la orden en la tabla ventas
    $comando = $con->prepare("INSERT INTO ventas (cliente_id, fecha_venta, subtotal, igv, total, estado_venta) VALUES (:cliente_id, :fecha_venta, :subtotal, :igv, :total, 'completado')");
    $comando->execute([
        ':cliente_id' => $cliente_id,
        ':fecha_venta' => $fecha_venta,
        ':subtotal' => $subtotal,
        ':igv' => $igv,
        ':total' => $total
    ]);

    $venta_id = $con->lastInsertId();

    // Insertar los detalles de la venta
    foreach ($productos as $producto) {
        $cantidad = $_SESSION['cart'][$producto['id']];
        $precio_unitario = $producto['precio_unitario'];
        $comando = $con->prepare("INSERT INTO detalles_ventas (venta_id, producto_id, cantidad, precio_unitario) VALUES (:venta_id, :producto_id, :cantidad, :precio_unitario)");
        $comando->execute([
            ':venta_id' => $venta_id,
            ':producto_id' => $producto['id'],
            ':cantidad' => $cantidad,
            ':precio_unitario' => $precio_unitario
        ]);

        // Actualizar el stock del producto
        $nuevo_stock = $producto['stock_disponible'] - $cantidad;
        $comando = $con->prepare("UPDATE productos SET stock_disponible = :nuevo_stock WHERE id = :producto_id");
        $comando->execute([
            ':nuevo_stock' => $nuevo_stock,
            ':producto_id' => $producto['id']
        ]);
    }

    // Vaciar el carrito
    $_SESSION['cart'] = array();

    // Redirigir a una página de confirmación
    header('Location: confirmacion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pagos - PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/assets/js/functions.js"></script>

    <style>
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
    </style>

</head>
<body>
    <div class="container">
        <h1>Detalles de la compra</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $subtotal = 0;
                    foreach ($productos as $producto) {
                        $cantidad = $_SESSION['cart'][$producto['id']];
                        $precio_unitario = $producto['precio_unitario'];
                        $total_producto = $cantidad * $precio_unitario;
                        $subtotal += $total_producto;
                        ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo 'S/.' . $precio_unitario; ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td><?php echo 'S/.' . $total_producto; ?></td>
                        </tr>
                        <?php
                    }
                    $igv = $subtotal * 0.18;
                    $total = $subtotal + $igv;
                ?>
                <tr>
                    <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                    <td><?php echo 'S/.' . $subtotal; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>IGV (18%):</strong></td>
                    <td><?php echo 'S/.' . $igv; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td><?php echo 'S/.' . $total; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="btn-container">
            <a href="/Views/carrito/cart.php" class="btn btn-warning" onclick="confirmarRetroceso(event)"><i class="glyphicon glyphicon-menu-left"></i> Volver al carrito</a>
            <form method="post" action="pagos.php">
                <button type="submit" class="btn btn-success" onclick="confirmarDetalleCompra(event)">Confirmar Compra</button>
            </form>
        </div>
    </div>
</body>
</html>