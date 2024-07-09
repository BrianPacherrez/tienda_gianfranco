<?php
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $comando = $con->prepare("SELECT c.*, ca.rol 
        FROM clientes c 
        JOIN cargos ca ON c.tipo_usuario = ca.id");
    $comando->execute();
    $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);


?>