<?php

require_once('User.php');

session_start();

$user = new User();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->login($username, $password)) {
        header("Location: welcome.php");
    } else {
        $loginError = "Invalid username or password";
    }
}

if (isset($_GET['logout'])) {
    $user->logout();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
        <?php if (isset($loginError)): ?>
            <p style="color: red;"><?php echo $loginError; ?></p>
        <?php endif; ?>
    </form>
    <p><a href="register.php">Register</a></p>
</body>
</html>
