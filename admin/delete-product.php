<?php
require_once 'auth_guard.php';
require_once 'ManageProduct.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productObj = new ManageProduct();
    if ($productObj->deleteProduct((int)$_GET['id'])) {
        header('Location: adminproduct.php?message=Product deleted successfully.');
    } else {
        header('Location: adminproduct.php?error=Failed to delete product.');
    }
} else {
    header('Location: adminproduct.php');
}
exit;
