<?php
require_once 'ManageAdmin.php';

$adminObj = new ManageAdmin();
$admins = $adminObj->getAllAdmins();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1><b><a href="index.php"><i class="fa-solid fa-arrow-left"></i></a></b>Manage Admin</h1>

        <a href="add-admin.php" class="btn-add">Add Admin</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($admins)): ?>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= htmlspecialchars($admin['id']) ?></td>
                            <td><?= htmlspecialchars($admin['username']) ?></td>
                            <td>
                                <a href="edit-admin.php?id=<?= $admin['id'] ?>" class="btn-edit">Edit</a>
                                <a href="delete-admin.php?id=<?= $admin['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No admins found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
