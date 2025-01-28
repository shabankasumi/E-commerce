<?php
require_once 'ManageProduct.php';
$productObj = new ManageProduct($conn);

$id = $_GET['id'];

$productObj->deleteProduct($id);
header("Location: adminproducts.php");
exit();
?>
