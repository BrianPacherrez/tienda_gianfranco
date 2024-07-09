<?php 
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $id = $_GET['id'];

    $query = $con->prepare("DELETE FROM productos WHERE id=?");
    $query->execute([$id]);
    $numEliminar = $query->rowCount();
    
    if($numEliminar > 0){
        $sql_reset = "ALTER TABLE productos AUTO_INCREMENT = 1";
        $con->exec($sql_reset);
        header("Location: ../../Views/dashboard/productos.php");
        exit();
    }
?>