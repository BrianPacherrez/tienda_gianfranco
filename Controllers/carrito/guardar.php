<!-- <?php
session_start();

require '../../Model/database.php';
$db = new Database();
$con = $db->conectar();

$correcto = false;

if (isset($_POST['id']) && isset($_POST['cantidad'])) {
    // Actualizar el carrito
    $producto_id = $_POST['id'];
    $cantidad = intval($_POST['cantidad']);

    if (isset($_SESSION['cart'][$producto_id])) {
        $_SESSION['cart'][$producto_id] = $cantidad;
        echo json_encode(['status' => 'success', 'message' => 'Cantidad actualizada correctamente']);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'El producto no se encuentra en el carrito']);
        exit();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos no válidos recibidos']);
    exit();
}
?>