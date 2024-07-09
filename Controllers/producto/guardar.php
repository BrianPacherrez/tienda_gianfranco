<?php 
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $correcto = false;

    if (isset($_POST['id'])) {
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio_unitario = $_POST['precio_unitario'];
        $stock_disponible = $_POST['stock_disponible'];
        $categoria_id = $_POST['categoria_id'];
        
        $query = $con->prepare("UPDATE productos SET nombre = ?, precio_unitario = ?, 
        stock_disponible = ?, categoria_id = ? WHERE id = ?");
        $resultado = $query->execute(array($nombre, $precio_unitario, $stock_disponible, $categoria_id, $id));
    
        if ($resultado) {
            $correcto = true;
        } 
    } else {
        
        $nombre = $_POST['nombre'];
        $precio_unitario = $_POST['precio_unitario'];
        $stock_disponible = $_POST['stock_disponible'];
        $categoria_id = $_POST['categoria_id'];
        
        $query = $con->prepare("INSERT INTO productos (nombre, precio_unitario, stock_disponible,
            categoria_id) VALUES (:nomb, :preu, :stck, :catg)");
        $resultado = $query->execute(array(
            'nomb' => $nombre, 
            'preu' => $precio_unitario, 
            'stck' => $stock_disponible,
            'catg' => $categoria_id,  
        ));
    
        if ($resultado) {
            $correcto = true;
            echo $con->lastInsertId();
        } 
    }
    
    if ($correcto) {
        header('Location: ../../Views/dashboard/productos.php');
    } else {
        echo "Error al guardar los datos.";
    }
?>