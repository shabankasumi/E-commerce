<?php
require_once 'auth_guard.php';
require_once 'constant.php';
require_once 'ManageOrder.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: orders.php');
    exit;
}

$orderId = (int)$_GET['id'];
$orderManager = new ManageOrder();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $orderManager->updateOrder($orderId, $status);
    header('Location: orders.php');
    exit;
}

$orders = $orderManager->getAllOrders();
$order = null;
foreach ($orders as $o) {
    if ((int)$o['id'] === $orderId) {
        $order = $o;
        break;
    }
}

if (!$order) {
    header('Location: orders.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><b><a href="orders.php"><i class="fa-solid fa-arrow-left"></i></a></b> Edit Order #<?= $orderId ?></h1>

        <form method="POST" action="edit-order.php?id=<?= $orderId ?>">
            <label for="status">Order Status:</label>
            <select name="status" id="status">
                <option value="pending"   <?= $order['status'] === 'pending'   ? 'selected' : '' ?>>Pending</option>
                <option value="shipped"   <?= $order['status'] === 'shipped'   ? 'selected' : '' ?>>Shipped</option>
                <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
            </select>
            <button type="submit" class="btn-primary">Update Status</button>
        </form>
    </div>
</body>
</html>
