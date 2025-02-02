<?php include("partials/header.php");
require_once 'ManageUser.php';
require_once'ManageOrder.php';
require_once'ManageAdmin.php';
require_once'ManageProduct.php';


$adminObj = new ManageAdmin();
$totalAdmins = $adminObj->countAdmins();

$productObj = new ManageProduct();
$totalProducts = $productObj->countProducts();

$orderObj=new ManageOrder();
$totalOrders= $orderObj-> countOrders();
// Create an instance of the ManageUser class
$userObj = new ManageUser(); 

// Get total users count
$totalUsers = $userObj->countUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>



    <div class="dashboard">
        <h1>Welcome to the Admin Dashboard</h1>
        <div class="admin-sections">
            
            <div class="section">
                <h2>Products</h2>
                <h1><b><?= $totalProducts ?></b></h1>
                <a href="adminproduct.php" class="btn">View Products</a>
            </div>

           
            <div class="section">
                <h2>Orders</h2>
                <h1><b><?= $totalOrders ?></b></h1>
                <a href="orders.php" class="btn">View Orders</a>
            </div>

            
            <div class="section">
                <h2>Users</h2>
                <h1><b><?= $totalUsers ?></b></h1>
                <a href="user.php" class="btn">View Users</a>
            </div>

           
            <div class="section">
                <h2>Admins</h2>
                <h1><b><?= $totalAdmins ?></b></h1>
                <a href="admin.php" class="btn">View Admins</a>
            </div>
        </div>
    </div>
</body>
</html>