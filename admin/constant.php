<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    define('SITEURL', 'http://localhost:8008');
    define('LOCALHOST', '127.0.0.1');
    define('DB_PORT',     3307);
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'E-commerce');


    class Database {
        private $conn;

        public function __construct() {
            $this->conn = $this->connect();
        }

        private function connect() {
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            return $conn;
        }

        public function getConnection() {
            return $this->conn;
        }
    }
?>
