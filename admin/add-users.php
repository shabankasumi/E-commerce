<?php
require_once 'ManageUser.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

 
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        $userObj = new ManageUser();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
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
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>
<body>

    <div class="dashboard">
    <h1><b><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></b>Add User</h1>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

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
