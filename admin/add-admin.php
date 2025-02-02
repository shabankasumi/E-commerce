<?php
require_once 'ManageAdmin.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch user inputs from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs (you can add more validations as needed)
    if (empty($username) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        $adminObj = new ManageAdmin();

        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the admin into the database
        if ($adminObj->addAdmin($username, $hashed_password)) {
            $success_message = "Admin added successfully!";
            header('Location: admin.php');
            exit();
        } else {
            $error_message = "Failed to add admin.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container">
        <h1><b><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></b>Add Admin</h1>

        <!-- Display success or error message -->
        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Admin Add Form -->
        <form action="add-admin.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="btn-primary">Add Admin</button>
        </form>
    </div>
</body>
</html>
