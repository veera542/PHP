<?php

require_once('User.php');

$user = new User();

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->register($username, $password)) {
        header("Location: login.php");
    } else {
        $registrationError = "Registration failed";
    }
}
?>

<!-- Your HTML code for the registration form -->

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="register" value="Register">
        <?php if (isset($registrationError)): ?>
            <p><?php echo $registrationError; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
