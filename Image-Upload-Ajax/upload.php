<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['userImage'])) {
    $uploadDirectory = "images/";
    
    // Check for errors during file upload
    if ($_FILES['userImage']['error'] === UPLOAD_ERR_OK) {
        $sourcePath = $_FILES['userImage']['tmp_name'];
        $fileName = basename($_FILES['userImage']['name']);
        $targetPath = $uploadDirectory . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($sourcePath, $targetPath)) {
            // Database connection (replace with your database configuration)
            $conn = mysqli_connect("localhost", "root", "", "ajax");
            
            if (!$conn) {
                die("Database connection failed: " . mysqli_connect_error());
            }
            
            // Sanitize the file name before inserting it into the database
            $image_up = mysqli_real_escape_string($conn, $fileName);
            
            // Insert the image file name into the database
            $sql = "INSERT INTO tbl_image (`image`) VALUES ('$image_up')";
            $sql_exec = mysqli_query($conn, $sql);

            if (!$sql_exec) {
                die("Database query failed: " . mysqli_error($conn));
            }

            // Fetch the recently inserted image record from the database
            $data = "SELECT * FROM tbl_image WHERE image = '$image_up'";
            $exec = mysqli_query($conn, $data);
            
            if (!$exec) {
                die("Database query failed: " . mysqli_error($conn));
            }
            
            $fetch = mysqli_fetch_array($exec);
            
            // Display the uploaded image
            ?>
            <div class="image-container">
                <img src="<?php echo $uploadDirectory . $fetch['image']; ?>" width="100px" height="100px" />
                <div class="image-delete" onClick="deleteImage('<?php echo $fetch['image']; ?>')">Remove</div>
            </div>
            <?php
        } else {
            echo "Error moving the uploaded file to the target directory.";
        }
    } else {
        echo "Error during file upload: " . $_FILES['userImage']['error'];
    }
} else {
    echo "No file uploaded or invalid request.";
}
?>
