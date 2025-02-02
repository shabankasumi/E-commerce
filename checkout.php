<?php
session_start();
require_once './admin/ManageProduct.php';
require_once './admin/ManageOrder.php';

// Check if user is logged in by verifying if 'user_id' is in session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Retrieve the user ID from the session
} else {
    // Redirect the user to the login page if not logged in
    header('Location: login.php');
    exit();
}

$orderObj = new ManageOrder();
$productObj = new ManageProduct();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Check if the cart has items
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $productDetails = [];
        $totalAmount = 0;

        // Loop through the cart and gather product details
        foreach ($_SESSION['cart'] as $productId => $item) {
            $product = $productObj->getProductById($productId); // Fetch product by ID
            $productDetails[] = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $item['quantity']
            ];
            $totalAmount += $product['price'] * $item['quantity']; // Calculate total amount
        }

        // Insert order into the database
        $status = 'pending'; // Set status as pending
        $orderDetails = json_encode($productDetails); // Convert product details to JSON format

        if ($orderObj->addOrder($userId, $orderDetails, $totalAmount, $status)) {
            // Clear the cart after successful order placement
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
