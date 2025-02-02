<?php
require_once 'constant.php';
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
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><b><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></b>Manage Products</h1>
        <a href="add-product.php" class="btn btn-add">Add Product</a>

        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['id']); ?></td>
                            <td><?= htmlspecialchars($product['name']); ?></td>
                            <td><?= htmlspecialchars($product['description']); ?></td>
                            <td>$<?= number_format($product['price'], 2); ?></td>
                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($product['image']); ?>" width="50" height="50" alt="Product Image">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit-product.php?id=<?= $product['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="delete-products.php?id=<?= $product['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
