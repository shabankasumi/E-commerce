<?php
require_once 'ManageUser.php';

$userObj = new ManageUser(); 
$users = $userObj->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1><b><a href="index.php"><-</a></b></h1>
        <h1>Manage Users</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
                <a href="add-users.php">ADD USER</a>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>********</td>
                        <td>
                            <a href="edit-users.php?id=<?= $user['id'] ?>" class="btn-edit">Edit</a>
                            <a href="delete-users.php?id=<?= $user['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
