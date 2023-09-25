<?php

require_once('User.php');

session_start();

$user = new User();

if (!$user->isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <p>This is your personalized welcome page.</p>
    <p><a href="update_user.php">Update User Details</a></p>
    <p><a href="login.php?logout=true">Logout</a></p>
</body>
</html>
