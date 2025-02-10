<?php

session_start(); 


$isLoggedIn = isset($_SESSION['user_id']);
$userRole = $isLoggedIn ? $_SESSION['role'] : ''; 
$userId = $_SESSION['user_id']; 

require_once './admin/ManageProduct.php';
require_once './admin/ManageOrder.php';


$orderObj = new ManageOrder();

$productObj = new ManageProduct();
$products = $productObj->getAllProducts(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];  
    $quantity = $_POST['quantity'] ?? 1; 

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'quantity' => $quantity
        ];
    }

    header('Location: products.php');
    exit();
}

if (isset($_POST['update_cart'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action']; 

    if (isset($_SESSION['cart'][$product_id])) {
        if ($action == 'increase') {
            $_SESSION['cart'][$product_id]['quantity']++;
        } elseif ($action == 'decrease' && $_SESSION['cart'][$product_id]['quantity'] > 1) {
            $_SESSION['cart'][$product_id]['quantity']--;
        }
    }

    
    header('Location: products.php');
    exit();
}


if (isset($_POST['remove_item'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header('Location: products.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $productDetails = [];
        $totalAmount = 0;

        foreach ($_SESSION['cart'] as $productId => $item) {
            $product = $productObj->getProductById($productId); 
            $productDetails[] = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $item['quantity']
            ];
            $totalAmount += $product['price'] * $item['quantity']; 
        }

        $status = 'pending'; 
        $orderDetails = json_encode($productDetails); 

        if ($orderObj->addOrder($userId, $orderDetails, $totalAmount, $status)) {
            unset($_SESSION['cart']);
            echo "Order placed successfully!";
            header('Location: products.php');
        } else {
            echo "Error placing order.";
        }
    } else {
        echo "Your cart is empty.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="products.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<section class="header">
        <a href="index.php"> <img class="logo" src="images/logoblack.png" alt="Logo"></a>
        
        <nav class="nav">
            <div class="nav-links" id="navlinks">
                 <i class="fa-solid fa-x" onclick="hidemenu()"></i>
                
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="about-us.html">About Us</a></li>
                    
                    <?php if ($isLoggedIn): ?>
                        <li><a href="logout.php" class="btn-logout">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php"><i class="fa-regular fa-user"></i> Login</a></li>
                    <?php endif; ?>

                   
                </ul>
            </div>
            <i class="fa-solid fa-bars hamburger" onclick="showmenu()"></i>
        </nav>
    </section>

    <div class="row"> 
        <?php 
        if ($products) {
            while ($row = $products->fetch_assoc()) {
        ?>
            <div class="photo">
                <img src="admin/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p>$<?php echo number_format($row['price'], 2); ?></p> 

                <form method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity" class="quantity-input" value="1" min="1">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        <?php 
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>

    <div class="showcart">
        <div class="carticon">
            <i class="fa-solid fa-cart-shopping" onclick="toggleCart()"></i>
            <span><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
        </div>
        <div class="carttab" id="cart-tab">
            <h1>Shopping Cart</h1>
            <div class="listcart">
                <?php
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $productId => $item) {
                        $product = $productObj->getProductById($productId);
                ?>
                <div class="item">
                    <div class="image">
                        <img src="admin/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="">
                    </div>
                    <div class="name"><?php echo htmlspecialchars($product['name']); ?></div>
                    <div class="totalprice">$<?php echo number_format($product['price'] * $item['quantity'], 2); ?></div>
                    <div class="quantity">
                        <span><?php echo $item['quantity']; ?></span>
                        <form method="POST" class="remove-item-form">
                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                            <button type="submit" name="remove_item" class="remove-item">X</button>
                        </form>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
            </div>
            <div class="btn">
                
                <button class="close" onclick="toggleCart()">CLOSE</button>
                <form method="POST">
                    <button type="submit" name="checkout">CHECKOUT</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showmenu() {
    const navlinks = document.getElementById('navlinks');
    navlinks.classList.add('open');
}

function hidemenu() {
    const navlinks = document.getElementById('navlinks');
    navlinks.classList.remove('open');
}


        function toggleCart() {
            const cartTab = document.getElementById('cart-tab');
            cartTab.classList.toggle('open');
        }
    </script>
</body>
</html>
