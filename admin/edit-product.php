<?php
require_once 'ManageProduct.php';

$productObj = new ManageProduct();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Product ID.");
}

$id = $_GET['id'];
$product = $productObj->getProductById($id);

if (!$product) {
    die("Product not found.");
}
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $product['image']; // Default to existing image

    // Handle file upload if a new image is selected
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . basename($_FILES['image']['name']); // Unique filename
        $imagePath = "../images/" . $image;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            die("Error uploading image.");
        }
    }

    // Update the product
    $isUpdated = $productObj->updateProduct($id, $name, $description, $price, $image);

    if ($isUpdated) {
        header("Location: adminproduct.php");
        exit();
    } else {
        echo "<p>Error updating product.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><b><a href="adminproduct.php"><i class="fa-solid fa-arrow-left"></i></a></b>Edit Products</h1>
        <form method="POST" enctype="multipart/form-data">
            <div>
                <label>Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div>
                <label>Description:</label>
                <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            <div>
                <label>Price:</label>
                <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" required>
            </div>
            <div>
                <label>Image:</label>
                <input type="file" name="image">
                <p>Current Image:</p>
                <img src="../images/<?= htmlspecialchars($product['image']) ?>" width="100" alt="Product Image">
            </div>
            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
