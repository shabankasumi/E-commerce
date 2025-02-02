<?php
require_once('ManageProduct.php');

$manageProduct = new ManageProduct();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = $_POST['price'];

    // Handle image upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $image = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $image;
        
        // Move uploaded file to the uploads directory
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            echo "Error uploading image.";
            exit;
        }
    }

    $isAdded = $manageProduct->addProduct($name, $description, $price, $image);
    
    if ($isAdded) {
        header("Location: adminproduct.php?success=1");
        exit;
    } else {
        echo "Error adding product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
</head>
<body>
    <h1><b><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></b>Add Product</h1>

    
    <form method="POST" action="add-product.php" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" step="0.01" required><br>

        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image"><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
