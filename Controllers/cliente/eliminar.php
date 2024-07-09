<?php 
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $cod_cliente = $_GET['id'];

    $query = $con->prepare("DELETE FROM clientes WHERE cod_cliente=?");
    $query->execute([$cod_cliente]);
    $numEliminar = $query->rowCount();
    
    if($numEliminar > 0){
        $sql_reset = "ALTER TABLE clientes AUTO_INCREMENT = 1";
        $con->exec($sql_reset);
        Header("Location: ../../Views/dashboard/usuarios.php");
        exit();
    }
?>