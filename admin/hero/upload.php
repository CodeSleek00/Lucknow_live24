<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$image=$_FILES['image']['name'];
$tmp=$_FILES['image']['tmp_name'];

move_uploaded_file($tmp,"uploads/".$image);

mysqli_query($conn,"INSERT INTO hero_images(image) VALUES('$image')");

header("Location: admin_dashboard.php");
?>