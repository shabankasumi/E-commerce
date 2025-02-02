<?php
require_once 'ManageAdmin.php';

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];
    $adminObj = new ManageAdmin();

    $adminDetails = $adminObj->getAdminById($admin_id);

    if (!$adminDetails) {
        header("Location: admin.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashed_password = $adminDetails['password'];
        }
        if ($adminObj->updateAdmin($admin_id, $username, $hashed_password)) {
            $success_message = "Admin updated successfully!";
            header("Location: admin.php");
        } else {
            $error_message = "Failed to update admin!";
        }
    }
} else {
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>


    <div class="dashboard">
        <h1>Edit Admin</h1>

        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="edit-admin.php?id=<?php echo $admin_id; ?>" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo $adminDetails['username']; ?>" required>

            <label for="password">Password (Leave empty to keep current password)</label>
            <input type="password" name="password" id="password">

            <button type="submit" class="btn-primary">Update Admin</button>
        </form>
    </div>
</body>
</html>
