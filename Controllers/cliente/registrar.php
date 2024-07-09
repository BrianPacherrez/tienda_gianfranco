<?php 
    require '../../Model/database.php';

    $db = new Database();
    $con = $db->conectar();

    $correcto = false;
        
        // Nuevo cliente
        $cod_cliente = $_POST['cod_cliente'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['dni'];
        $celular = $_POST['celular'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        
        $query = $con->prepare("INSERT INTO clientes (cod_cliente, nombres, apellidos, dni, celular, usuario, contraseña) VALUES (:cod, :nom, :ape, :dni, :cel, :usu, :con)");
        $resultado = $query->execute(array(
            'cod' => $cod_cliente,
            'nom' => $nombres, 
            'ape' => $apellidos, 
            'dni' => $dni, 
            'cel' => $celular, 
            'usu' => $usuario,  
            'con' => $contraseña
        ));
    
        if ($resultado) {
            $correcto = true;
            echo $con->lastInsertId();
        } 
        if ($correcto) {
            Header('Location: ../../Views/login/login.php');
        } else {
            echo "Error al guardar los datos.";
        }

?>
