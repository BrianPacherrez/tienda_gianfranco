<?php
require '../../Model/database.php';

$db = new Database();
$con = $db->conectar();

$id = $_GET['id'];

$query = $con->prepare("SELECT p.*, ca.nombre_cat AS nombre_categoria
    FROM productos p
    JOIN categorias ca ON p.categoria_id = ca.id
    WHERE p.id = :id");
$query->execute(['id' => $id]);
$row = $query->fetch(PDO::FETCH_ASSOC);

// Obtener todas las categorías disponibles para el select
$query_categorias = $con->query("SELECT id, nombre_cat FROM categorias");
$categorias = $query_categorias->fetchAll(PDO::FETCH_ASSOC);
?>