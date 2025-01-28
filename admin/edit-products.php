<?php
require_once 'ManageProduct.php';
$productObj = new ManageProduct($conn);

$id = $_GET['id'];
$product = $productObj->getProductById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $product['image'];

    if ($_FILES['image']['name']) {
        $imagePath = "../images/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $productObj->updateProduct($id, $name, $description, $price, $image);
    header("Location: adminproducts.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
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
                <p>Current Image: <img src="../images/<?= htmlspecialchars($product['image']) ?>" width="100"></p>
            </div>
            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
