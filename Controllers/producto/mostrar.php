<?php
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $comando = $con->prepare("SELECT p.*, ca.nombre_cat 
        FROM productos p 
        JOIN categorias ca ON p.categoria_id = ca.id");
    $comando->execute();
    $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para obtener datos de ventas
    $comandoVentas = $con->prepare("SELECT p.nombre, SUM(dv.cantidad) AS cantidad_vendida
        FROM detalles_ventas dv
        JOIN productos p ON dv.producto_id = p.id
        GROUP BY p.nombre");
    $comandoVentas->execute();
    $resultadoVentas = $comandoVentas->fetchAll(PDO::FETCH_ASSOC);
?>