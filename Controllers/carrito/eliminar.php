<?php
session_start();

// Obtener el ID del producto desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0 && isset($_SESSION['cart'][$id])) {
    // Eliminar el producto del carrito
    unset($_SESSION['cart'][$id]);
}

// Redirigir de vuelta al carrito
header("Location: ../../Views/carrito/cart.php");
exit();
?>