<?php
require_once 'ManageProduct.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $productObj = new ManageProduct();

    if ($productObj->deleteProduct($product_id)) {
        header("Location: adminproduct.php?message=Product deleted successfully.");
    } else {
        header("Location: adminproduct.php?error=Failed to delete product.");
    }
} else {
    header("Location: adminproduct.php");
}
exit;
?>
