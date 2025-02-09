<?php
session_start(); 

$isLoggedIn = isset($_SESSION['user_id']);
$userRole = $isLoggedIn ? $_SESSION['role'] : '';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

                    <?php if ($isLoggedIn && $userRole == 'admin'): ?>
                        <li><a href="./admin/index.php">Dashboard</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <i class="fa-solid fa-bars hamburger" onclick="showmenu()"></i>
        </nav>
        
        <div class="text-box">
            <h1>World's biggest brands store</h1>
            <p>In our store you can find clothing's products of biggest brands for a better price</p>
            <a href="products.php" class="hero-btn">Look at the products</a>
        </div>
    </section>

    <section class="newproducts">
        <H1>New arrivals</H1>
        <p>Look at our new collection</p>
        <div class="slider">
            <div class="slider-track">
                <div class="slide"><img src="images/_ALE0015.png" alt="Photo 1"></div>
                <div class="slide"><img src="images/all-black-suits.png" alt="Photo 2"></div>
                <div class="slide"><img src="images/female.jpg" alt="Photo 3"></div>
            </div>
            <div class="slider-buttons">
                <button class="slider-button" id="prev">&#9664;</button>
                <button class="slider-button" id="next">&#9654;</button>
            </div>
        </div>
    </section>

    <footer>
        <div class="f">
            <h2>About our company</h2>
            <h2>Our Links</h2>
            <div class="ff">
                <a href=""><img src="images/facebook.png" alt="" width="32px" height="32px"></a>
                <a href=""><img src="images/twitter.png" alt="" width="32px" height="32px"></a>
                <a href=""><img src="images/instagram.png" alt="" width="32px" height="32px"></a>
                <a href=""><img src="images/pinterest.png" alt="" width="32px" height="32px"></a>
            </div>
        </div>
        <div class="footermain">
            <div class="footerleft">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry...</p>
            </div>
            <div class="footercenter">
                <p>Advertise</p>
                <p>Support</p>
                <p>Our Company</p>
                <p>Contact</p>
            </div>
            <div class="footerright">
                <p>Terms of use</p>
                <p>Privacy Policy</p>
            </div>
        </div>
        <div class="fundi">
            <p>Copyright 2020 our Company. All rights reserved.</p>
            <p>Designed by sjhdjsdjhd</p>
        </div>
    </footer>

    <script>
        var navlinks = document.getElementById("navlinks");
        function showmenu() {
            navlinks.style.right = "0";
        }
        function hidemenu() {
            navlinks.style.right = "-200px";
        }

        const sliderTrack = document.querySelector('.slider-track');
        const slides = document.querySelectorAll('.slide');
        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');
        
        let currentIndex = 0;

        function updateSliderPosition() {
            const offset = -currentIndex * 100;
            sliderTrack.style.transform = `translateX(${offset}%)`;
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? slides.length - 1 : currentIndex - 1;
            updateSliderPosition();
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex === slides.length - 1) ? 0 : currentIndex + 1;
            updateSliderPosition();
        });
    </script>
</body>
</html>
