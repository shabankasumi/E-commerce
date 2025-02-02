<?php
require_once 'ManageOrder.php';

$orderObj = new ManageOrder(); 
$orders = $orderObj->getAllOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


</head>
<body>
    <div class="container">
        
        <h1><b><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></b>Manage Orders</h1>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Product Details</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['user_id']) ?></td>
                        <td>
                            <?php
                                // Decode the JSON product details
                                $products = json_decode($order['product_details'], true);

                                // Loop through each product and display details
                                if ($products) {
                                    echo "Product: ";
                                    foreach ($products as $product) {
                                        echo "<div class='product-details'>";
                                        echo "Name: " . htmlspecialchars($product['name']) . "<br>";
                                        echo "Price: $" . number_format($product['price'], 2) . "<br>";
                                        echo "Quantity: " . htmlspecialchars($product['quantity']) . "<br><br>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "No product details available.";
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($order['total_amount']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>
                            <a href="edit-order.php?id=<?= $order['id'] ?>" class="btn-edit">Edit</a>
                            <a href="delete-order.php?id=<?= $order['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>
    </div>
</body>
</html>
