<?php
if (!empty($_POST["path"])) {

    $conn = mysqli_connect("localhost", "root", "", "ajax");

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $imagePath = $_POST["path"];

    // Sanitize the image path to prevent SQL injection
    $imagePath = mysqli_real_escape_string($conn, $imagePath);

    // Fetch the image record from the database
    $data = "SELECT * FROM tbl_image WHERE image = '$imagePath'";
    $sql_exec1 = mysqli_query($conn, $data);

    if (!$sql_exec1) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $sql_fetch = mysqli_fetch_array($sql_exec1);

    // Delete the image record from the database
    $sql = "DELETE FROM tbl_image WHERE image = '$imagePath'";
    $sql_exec = mysqli_query($conn, $sql);

    if (!$sql_exec) {
        die("Database query failed: " . mysqli_error($conn));
    }

    // Delete the image file from the server
    $imageFilePath = 'images/' . $sql_fetch['image'];

    if (file_exists($imageFilePath)) {
        if (unlink($imageFilePath)) {
            echo "Image deleted successfully.";
        } else {
            echo "Error deleting the image file.";
        }
    } else {
        echo "Image file not found.";
    }
} else {
    echo "Invalid request. No image path provided.";
}
?>
