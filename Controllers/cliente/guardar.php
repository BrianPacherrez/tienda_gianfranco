<?php 
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $correcto = false;

    if (isset($_POST['cod_cliente'])) {
        
        $cod_cliente = $_POST['cod_cliente'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['dni'];
        $celular = $_POST['celular'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $tipo_usuario = $_POST['tipo_usuario'];
    
        $query = $con->prepare("UPDATE clientes SET nombres = ?, apellidos = ?, dni = ?, 
        celular = ?, usuario = ?, contraseña = ?, tipo_usuario = ? WHERE cod_cliente = ?");
        $resultado = $query->execute(array($nombres, $apellidos, $dni, $celular, $usuario, 
            $contraseña, $tipo_usuario ,$cod_cliente));
    
        if ($resultado) {
            $correcto = true;
        }
    } else {
        // Nuevo cliente
        $cod_cliente = $_POST['cod_cliente'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['dni'];
        $celular = $_POST['celular'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $tipo_usuario = $_POST['tipo_usuario'];
        
        $query = $con->prepare("INSERT INTO clientes (cod_cliente, nombres, apellidos, dni, celular, usuario, contraseña, tipo_usuario) VALUES (:cod, :nom, :ape, :dni, :cel, :usu, :con, :tpu)");
        $resultado = $query->execute(array(
            'cod' => $cod_cliente,
            'nom' => $nombres, 
            'ape' => $apellidos, 
            'dni' => $dni, 
            'cel' => $celular, 
            'usu' => $usuario,  
            'con' => $contraseña,
            'tpu' => $tipo_usuario
        ));
    
        if ($resultado) {
            $correcto = true;
            echo $con->lastInsertId();
        } 
    }
?>
