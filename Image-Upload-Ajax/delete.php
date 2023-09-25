<?php
if (!empty($_POST["path"])) {
    $conn = mysqli_connect("localhost", "root", "", "ajax");
    $sql = "DELETE FROM tbl_image  WHERE image='" . $_POST["path"] . "'";
    $sql_exec = mysqli_query($conn, $sql);
    $data = "select * FROM tbl_image where image='" . $_POST["path"] . "'";
    $sql_exec1 = mysqli_query($conn, $data);
    $sql_fetch = mysqli_fetch_array($sql_exec1);
    unlink('images/' . $sql_fetch['image']);
}
?>
