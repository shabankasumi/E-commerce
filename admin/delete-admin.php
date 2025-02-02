<?php
require_once 'ManageAdmin.php';

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    $adminObj = new ManageAdmin();

    if ($adminObj->deleteAdmin($admin_id)) {
        header("Location: admin.php?message=Admin deleted successfully.");
    } else {
        header("Location: admin.php?error=Failed to delete admin.");
    }
} else {
    header("Location: Admin.php");
}
exit;
?>
