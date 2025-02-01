<?php 
include('constant.php');

 $stmt =$conn->prepare("SELECT * FROM products LIMIT 4")
    $stmt->execute();
 $products= $stmt->get_result();
?>