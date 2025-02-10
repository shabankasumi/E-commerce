<?php
require_once './admin/constant.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

     $errors = [];

    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Enter a valid email address.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }

    if (empty($confirmPassword)) {
        $errors['confirmPassword'] = "Please confirm your password.";
    } elseif ($confirmPassword !== $password) {
        $errors['confirmPassword'] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $role = 'user';
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $role);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: login.php"); 
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error preparing statement: " . mysqli_error($conn); 
        }

        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Register</title>
</head>
<body>
    <div class="wrapper">
        <h1>Sign up</h1>
        <form id="signup-form" method="POST" action="register.php" onsubmit="return validateForm('signup-form')">
            <div class="input-box">
                <input name="username" type="text" style="padding-left: 10px;" placeholder="Username" required>
                <span class="error" style="color: red; font-size: 14px;"></span>
            </div>
            <div class="input-box">
                <input name="email" type="email" style="padding-left: 10px;" placeholder="Email" required>
                <span class="error" style="color: red; font-size: 14px;"></span>
            </div>
            <div class="input-box">
                <input name="password" type="password" style="padding-left: 10px;" placeholder="Password" required>
                <span class="error" style="color: red; font-size: 14px;"></span>
            </div>
            <div class="input-box">
                <input name="confirmPassword" type="password" style="padding-left: 10px;" placeholder="Confirm Password" required>
                <span class="error" style="color: red; font-size: 14px;"></span>
            </div>
            <button type="submit" class="btn">Sign up</button>
        </form>
        <div class="register-link">
            <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>

    <script>
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const username = form.querySelector('input[name="username"]');
            const email = form.querySelector('input[name="email"]');
            const password = form.querySelector('input[name="password"]');
            const confirmPassword = form.querySelector('input[name="confirmPassword"]');
            let isValid = true;

            form.querySelectorAll('.error').forEach(error => error.textContent = '');

            if (username.value.trim() === "") {
                username.nextElementSibling.textContent = 'Username is required.';
                isValid = false;
            }

            if (email.value.trim() === "") {
                email.nextElementSibling.textContent = 'Email is required.';
                isValid = false;
            } else if (!/\S+@\S+\.\S+/.test(email.value)) {
                email.nextElementSibling.textContent = 'Enter a valid email address.';
                isValid = false;
            }

            if (password.value.trim() === "") {
                password.nextElementSibling.textContent = 'Password is required.';
                isValid = false;
            } else if (password.value.length < 6) {
                password.nextElementSibling.textContent = 'Password must be at least 6 characters.';
                isValid = false;
            }

            if (confirmPassword.value.trim() === "") {
                confirmPassword.nextElementSibling.textContent = 'Please confirm your password.';
                isValid = false;
            } else if (confirmPassword.value !== password.value) {
                confirmPassword.nextElementSibling.textContent = 'Passwords do not match.';
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>

