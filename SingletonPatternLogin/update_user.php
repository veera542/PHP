<?php

require_once('User.php');

session_start();

$userModel = new UserModel($db);
$userController = new UserController($userModel);

if (!$userController->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];

    if ($userController->updateUser($_SESSION['user_id'], $newUsername, $newPassword)) {
        // User update successful, you can redirect to a success page
        header("Location: welcome.php");
        exit();
    } else {
        $updateError = "Update failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form method="post" action="update_user.php">
        <label for="newUsername">New Username:</label>
        <input type="text" name="newUsername" required><br>
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required><br>
        <input type="submit" name="update" value="Update">
        <?php if (isset($updateError)): ?>
            <p><?php echo $updateError; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
