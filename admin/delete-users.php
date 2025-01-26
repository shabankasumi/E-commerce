<?php
require_once 'ManageUser.php';

// Check if the user ID is provided via GET request
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Create an instance of the ManageUser class
    $userObj = new ManageUser();

    // Call the deleteUser method
    if ($userObj->deleteUser($user_id)) {
        // If deletion is successful, redirect to the user management page with a success message
        header("Location: user.php?message=User deleted successfully.");
    } else {
        // If deletion failed, redirect with an error message
        header("Location: user.php?error=Failed to delete user.");
    }
} else {
    // If ID is not set, redirect to user management page
    header("Location: user.php");
}
exit;
?>
