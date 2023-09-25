<?php
// User.php

require_once('Database.php');

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password)
    {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);

        $query = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
        $result = $this->db->query($query);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: login.php");
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function register($username, $password)
    {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        $result = $this->db->query($query);

        return $result;
    }
}
?>
