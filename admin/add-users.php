<?php
require_once 'ManageUser.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch user inputs from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs (you can add more validations as needed)
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        // Create an instance of ManageUser
        $userObj = new ManageUser();

        // Hash the password before storing it (for security reasons)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $userObj->addUser($username, $email, $hashed_password);
        $success_message = "User added successfully!";
        $locate = header('Location: user.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <div class="dashboard">
        <h1>Add User</h1>

        <!-- Display success or error message -->
        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- User Add Form -->
        <form action="add-users.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="btn-primary">Add User</button>
        </form>
    </div>
</body>
</html>
