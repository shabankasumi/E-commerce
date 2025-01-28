<?php
require_once 'ManageOrder.php';

$orderManager = new ManageOrder();

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $orderManager->deleteOrder($orderId);
}

header('Location: orders.php'); 
