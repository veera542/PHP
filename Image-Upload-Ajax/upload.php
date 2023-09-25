<?php
if (is_array($_FILES)) {

    $sourcePath = $_FILES['userImage']['tmp_name'];
    $targetPath = "images/" . $_FILES['userImage']['name'];
    if (move_uploaded_file($sourcePath, $targetPath)) {
        $image_up = $_FILES['userImage']['name'];
        $conn = mysqli_connect("localhost", "root", "", "ajax");
        $sql = "INSERT INTO tbl_image(`image`)
                values('" . $image_up . "')";
        $sql_exec = mysqli_query($conn, $sql);
        $data = "select * FROM tbl_image where image='" . $image_up . "'";
        $exec = mysqli_query($conn, $data);
        $fetch = mysqli_fetch_array($exec);
?>

        <div class="image-container">
            <img src="images/<?php echo $fetch['image']; ?>" width="100px" height="100px" />
            <div class="image-delete" onClick="deleteImage('<?php echo $image_up; ?>')">Remove</div>
        </div>

<?php

    }
}

?>
