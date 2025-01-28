<?php
require_once 'ManageUser.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $userObj = new ManageUser();

    $userDetails = $userObj->getUserById($user_id);

    if (!$userDetails) {
        header("Location: user.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashed_password = $userDetails['password'];
        }
        if ($userObj->updateUser($user_id, $username, $email, $hashed_password)) {
            $success_message = "User updated successfully!";
        } else {
            $error_message = "Failed to update user!";
        }
    }
} else {
    header("Location: user.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>


    <div class="dashboard">
        <h1>Edit User</h1>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="edit-users.php?id=<?php echo $user_id; ?>" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo $userDetails['username']; ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $userDetails['email']; ?>" required>

            <label for="password">Password (Leave empty to keep current password)</label>
            <input type="password" name="password" id="password">

            <button type="submit" class="btn-primary">Update User</button>
        </form>
    </div>
</body>
</html>
