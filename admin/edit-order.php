<?php
require_once './config/constant.php';
require_once './ManageOrder.php';

$orderManager = new ManageOrder();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];
    $orderManager->updateOrder($orderId, $status);
    header('Location: orders.php');  
}

$orderId = $_GET['id'];
?>
<form method="POST">
    <input type="hidden" name="order_id" value="<?php echo $orderId; ?>" />
    <label for="status">Order Status:</label>
    <select name="status">
        <option value="Pending">Pending</option>
        <option value="Shipped">Shipped</option>
        <option value="Delivered">Delivered</option>
    </select>
    <button type="submit">Update Status</button>
</form>
