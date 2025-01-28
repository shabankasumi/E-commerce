<?php
require_once 'ManageUser.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $userObj = new ManageUser();

    if ($userObj->deleteUser($user_id)) {
        header("Location: user.php?message=User deleted successfully.");
    } else {
        header("Location: user.php?error=Failed to delete user.");
    }
} else {
    header("Location: user.php");
}
exit;
?>
