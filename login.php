<?php
session_start();
require_once './admin/constant.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $errors = [];

    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (empty($errors)) {
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: index.php");
                exit();
            } else {
                $errors['password'] = "Invalid password.";
            }
        } else {
            $sql_admin = "SELECT * FROM admins WHERE username = ?";
            $stmt_admin = mysqli_prepare($conn, $sql_admin);
            mysqli_stmt_bind_param($stmt_admin, "s", $username);
            mysqli_stmt_execute($stmt_admin);
            $result_admin = mysqli_stmt_get_result($stmt_admin);

            if (mysqli_num_rows($result_admin) > 0) {
                $admin = mysqli_fetch_assoc($result_admin);

                if (password_verify($password, $admin['password'])) {
                    $_SESSION['user_id'] = $admin['id'];
                    $_SESSION['username'] = $admin['username'];
                    $_SESSION['role'] = 'admin';


                    header("Location: index.php");
                    exit();
                } else {
                    $errors['password'] = "Invalid password.";
                }
            } else {
                $errors['username'] = "No user found with that username in both user and admin tables.";
            }
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="login.php" id="login-form" method="POST" onsubmit="return validateForm('login-form')">
        <div class="wrapper">
            <h1>Login</h1>
            <div class="input-box">
                <input name="username" type="text" style="padding-left: 10px;" placeholder="Username" value="<?= isset($username) ? htmlspecialchars($username) : ''; ?>">
                <span class="error" style="color: red; font-size: 14px;">
                    <?= isset($errors['username']) ? $errors['username'] : ''; ?>
                </span>
            </div>
            <div class="input-box">
                <input name="password" type="password" style="padding-left: 10px;" placeholder="Password">
                <span class="error" style="color: red; font-size: 14px;">
                    <?= isset($errors['password']) ? $errors['password'] : ''; ?>
                </span>
            </div>
            <br />
        
            <div class="remember-forgot">
                <label><input type="checkbox" name="remember">Remember me</label>
                <a href="#">Forgot Password</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </form>

    <script>
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const username = form.querySelector('input[name="username"]');
            const password = form.querySelector('input[name="password"]');
            let isValid = true;

            form.querySelectorAll('.error').forEach(error => error.textContent = '');

            if (username.value.trim() === "") {
                username.nextElementSibling.textContent = 'Username is required.';
                isValid = false;
            }

            if (password.value.trim() === "") {
                password.nextElementSibling.textContent = 'Password is required.';
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>
