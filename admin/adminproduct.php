<?php
require_once '../config/constant.php';
require_once 'ManageProduct.php';

$db = new Database();
$conn = $db->getConnection();

$productObj = new ManageProduct($conn);
$products = $productObj->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <h1>Manage Products</h1>
    <a href="add-product.php" class="btn">Add Product</a>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($product['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['price']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['stock']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit-product.php?id=" . $product['id'] . "' class='btn'>Edit</a> ";
                    echo "<a href='delete-product.php?id=" . $product['id'] . "' class='btn btn-delete'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>