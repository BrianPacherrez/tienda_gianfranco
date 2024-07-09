<?php 
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $cod_cliente = $_GET['id'];

    $query = $con->prepare("SELECT c.*, ca.rol
        FROM clientes c
        JOIN cargos ca WHERE cod_cliente = :cod");
    $query->execute(['cod' => $cod_cliente,]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    
    
// Obtener todas los roles disponibles para el select
$query_cargos = $con->query("SELECT id, rol FROM cargos");
$cargos = $query_cargos->fetchAll(PDO::FETCH_ASSOC);


    // $num = $query->rowCount();
    
    
    
    // if ($num > 0) {
    //     $row = $query->fetch(PDO::FETCH_ASSOC);
        
        
        
    // } else {
    //     // header('Location: cuenta.php');
    //     header('Location: ./Views/dashboard/usuarios.php');
    // }
?>