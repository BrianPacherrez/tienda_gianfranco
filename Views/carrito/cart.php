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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>View Cart - PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/assets/js/functions.js"></script>

    <style>
        .container {
            padding: 20px;
        }

        input[type="number"] {
            width: 20%;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .text-derecha {
            margin-left: 100px;
        }
    </style>
    </style>



</head>
<body>
<div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
            <ul class="nav nav-pills">
                    <li role="presentation"><a href="/index.php" onclick="confirmarRetrocesoTienda(event)">Inicio</a></li>
                    <li role="presentation" class="active"><a href="cart.php">Carrito de Compras</a></li>
                    <li role="presentation"><a href="pagos.php">Pagar</a></li>
                </ul>
            </div>

            <div class="panel-body">
                <h1>Carrito de compras</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total = 0;
                            if (count($productos) > 0) {
                                foreach ($productos as $producto) {
                                    if (is_numeric($_SESSION['cart'][$producto['id']])) {
                                        ?>
                                        <tr>
                                            <td><?php echo $producto["nombre"]; ?></td>
                                            <td><?php echo 'S/.' . $producto["precio_unitario"]; ?></td>
                                            <td>
                                            <input type="number" class="form-control text-center"
                                                value="<?php echo $_SESSION['cart'][$producto['id']]; ?>"
                                                onchange="updateCartItem(this, '<?php echo $producto['id']; ?>'); validateQuantity(this, '<?php echo $producto['id']; ?>')"
                                                data-precio="<?php echo $producto['precio_unitario']; ?>"
                                                min="1">
                                            </td>
                                            <td><?php echo 'S/.' . number_format($_SESSION['cart'][$producto['id']] * $producto["precio_unitario"], 2, '.', ''); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-danger" onclick="eliminarPersona('<?php echo $producto["id"]; ?>', '../../Controllers/carrito/eliminar.php?id=<?php echo $producto["id"]; ?>')"><i class="glyphicon glyphicon-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $total += $_SESSION['cart'][$producto['id']] * $producto["precio_unitario"];
                                    } else {
                                        // Manejar el caso donde $_SESSION['cart'][$producto['id']] no es numérico
                                        // Puedes mostrar un mensaje de error o manejarlo según sea necesario
                                    }
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="5">
                                        <p>No has solicitado ningún producto.</p>
                                    </td>
                                </tr>
                            <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><a href="../../index.php" class="btn btn-warning"  onclick="confirmarRetrocesoTienda(event)"><i class="glyphicon glyphicon-menu-left"></i> Volver a la tienda</a></td>
                            <td colspan="2"></td>
                            <?php if (count($productos) > 0) { ?>
                                <td class="text-left"><strong>Total <?php echo 'S/.' . number_format($total, 2, '.', ''); ?></strong></td>
                                <td><a href="#" class="btn btn-success btn-block" onclick="confirmarCompra()">Pagar <i class="glyphicon glyphicon-menu-right"></i></a></td>
                            <?php } ?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Función para actualizar el total del carrito cuando se cambia la cantidad
        function updateCartItem(input, productId) {
            var cantidad = input.value;
            $.ajax({
                url: '../../Controllers/carrito/guardar.php', // Archivo PHP para guardar la cantidad actualizada
                method: 'POST',
                data: { id: productId, cantidad: cantidad },
                success: function(response) {
                    // Actualizar visualmente el total del producto en la tabla sin recargar la página
                    var totalProducto = cantidad * parseFloat(input.getAttribute('data-precio'));
                    var totalProductoFormatted = 'S/.' + totalProducto.toFixed(2);
                    input.parentNode.nextElementSibling.textContent = totalProductoFormatted; // Actualizar el total en la tabla
                    location.reload(); // Recargar la página para reflejar los cambios
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar el carrito:', error);
                    // Manejar errores si es necesario
                }
            });
        }

        function confirmarCompra() {
            // Verificar el stock antes de proceder con la compra
            var products = <?php echo json_encode($productos); ?>;
            var cartQuantities = <?php echo json_encode($_SESSION['cart']); ?>;
            var insufficientStockProducts = [];

            for (var i = 0; i < products.length; i++) {
                var productId = products[i]['id'];
                var cartQuantity = cartQuantities[productId];
                var availableStock = products[i]['stock_disponible'];

                if (cartQuantity > availableStock) {
                    insufficientStockProducts.push(products[i]['nombre']);
                }
            }

            if (insufficientStockProducts.length > 0) {
                // Mostrar mensaje de error si no hay suficiente stock
                var productList = insufficientStockProducts.join(', ');
                swal({
                    title: "Error, no hay suficiente stock disponible",
                    text: "Productos: " + productList,
                    icon: "error",
                    button: "Aceptar",
                    className: "swal-centered"
                });
                return;
            }

            // Si hay suficiente stock, confirmar la compra
            swal({
                title: "¿Confirmar compra?",
                text: "¿Estás seguro de proceder con la compra?",
                icon: "warning",
                buttons: ["Cancelar", "Confirmar"],
                dangerMode: false,
            })
            .then((willConfirm) => {
                if (willConfirm) {
                    window.location.href = "../../Views/carrito/pagos.php"; // Redirigir a la página de pagos
                } else {
                    swal("Compra cancelada", "Tu carrito sigue intacto.", "info");
                }
            });
        }

    </script>

</body>
</html>