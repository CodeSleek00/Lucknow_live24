<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['admin'])){
    header("Location: ../admin_login.php");
    exit();
}

$image = basename($_FILES['image']['name']);
$tmp = $_FILES['image']['tmp_name'];

if($image !== "" && move_uploaded_file($tmp, "uploads/" . $image)){
    mysqli_query($conn, "INSERT INTO hero_images(image) VALUES('$image')");
}

header("Location: hero_admin.php");
?>
