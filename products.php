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
        <a href="index.php"> <img class="logo"  src="images/logoblack.png" alt="Logo" ></a>
        
        <nav class="nav">
            <div class="nav-links" id="navlinks">
                 <i class="fa-solid fa-x" onclick="togglemenu()"></i>
                
                <ul>
                    <li><a href="index.php"></i>Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="about-us.html">About Us</a></li>
                    <li><a href="login.php"><i class="fa-regular fa-user"></i></a></li>
                </ul>
              
                
            </div>
            
            <i class="fa-solid fa-bars hamburger" onclick="togglemenu()"></i>
        
                </form>
            </div>
            
            </nav>
    </section>
    <div class="row"> 
        <?php 
        include('admin/get_products.php');
        ?>
         <?php 
        while($row= $products->fetch_assoc()){
        ?>
            
        <div class="photo">
            <img src="images/<?php echo['image'];?>" alt="">
            <h3><?php echo $row['name']; ?></h3>
            <p>$ <?php echo $row['price'] ?></p> 
            <button class="addtocart">Add to cart</button>
        </div>
       <?php   } ?>
    </div>
    <div class="showcart">
    <div class="carticon">
        <i class="fa-solid fa-cart-shopping" onclick="toggleCart()" ></i>
        <span>0</span>
    </div>
    <div class="carttab" id="cart-tab">
        <h1>Shoping cart</h1>
        <div class="listcart">
            <div class="item">
                <div class="image">
                    <img src="images/winter.jpg" alt="">
                </div>
                <div class="name">Winter Jacket</div>
                <div class="totalprice">120€</div>
                <div class="quantity">
                    <span class="minus">-</span>
                    <span>1</span>
                    <span class="plus">+</span>
                </div>
            </div>
        </div>
        <div class="btn">
            <button class="close" onclick="toggleCart()">CLOSE</button>
            <button class="checkout">CHECK OUT</button>
        </div>
    </div>
</div>

            <script>
               
                function togglemenu(){
                    const navlinks=document.getElementById('navlinks');
                    navlinks.classList.toggle('open');
                }
              
            </script>
            <script>
                function toggleCart() {
  const cartTab = document.getElementById('cart-tab');
  cartTab.classList.toggle('open'); 
}
               
            </script>
</body>
</html>