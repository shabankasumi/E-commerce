<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    define('SITEURL', 'http://localhost:8008/E-commerce');
    define('LOCALHOST', '127.0.0.1');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'E-commerce');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
?>
