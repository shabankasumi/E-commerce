<?php
require_once('../config/constant.php');
require_once('ManageProduct.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $db = new Database();
    $conn = $db->getConnection();
    $manageProduct = new ManageProduct($conn);
    
    $isAdded = $manageProduct->addProduct($name, $price, $stock);
    
    if ($isAdded) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product.";
    }
}
?>

<form method="POST" action="add-product.php">
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" required><br>
    
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required><br>
    
    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" required><br>
    
    <button type="submit">Add Product</button>
</form>
