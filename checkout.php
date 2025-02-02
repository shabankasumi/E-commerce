<?php
session_start();
require_once './admin/ManageProduct.php';
require_once './admin/ManageOrder.php';


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; 

    header('Location: login.php');
    exit();
}

$orderObj = new ManageOrder();
$productObj = new ManageProduct();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $productDetails = [];
        $totalAmount = 0;

        foreach ($_SESSION['cart'] as $productId => $item) {
            $product = $productObj->getProductById($productId); 
            $productDetails[] = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $item['quantity']
            ];
            $totalAmount += $product['price'] * $item['quantity']; 
        }

        $status = 'pending'; 
        $orderDetails = json_encode($productDetails); 

        if ($orderObj->addOrder($userId, $orderDetails, $totalAmount, $status)) {
            unset($_SESSION['cart']);
            echo "Order placed successfully!";
            header('Location: products.php');
        } else {
            echo "Error placing order.";
        }
    } else {
        echo "Your cart is empty.";
    }
}
?>

<form method="POST">
    <button type="submit" name="checkout">Checkout</button>
</form>
