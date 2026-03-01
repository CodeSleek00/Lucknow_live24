<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$id=$_GET['id'];

$data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM hero_images WHERE id=$id"));

unlink("../uploads/".$data['image']);

mysqli_query($conn,"DELETE FROM hero_images WHERE id=$id");

header("Location: admin_dashboard.php");
?>