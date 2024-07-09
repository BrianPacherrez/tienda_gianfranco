<?php
    session_start();

    if (isset($_GET['action']) && $_GET['action'] == 'addToCart') {
        $id = intval($_GET['id']);
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 1;
        } else {
            $_SESSION['cart'][$id]++;
        }
        // Contar el total de productos en el carrito
        $cartCount = array_sum($_SESSION['cart']);
        echo json_encode(array('cartCount' => $cartCount));
        exit();
    }
?>