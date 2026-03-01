<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['admin'])){
    header("Location: ../admin_login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0){
    header("Location: hero_admin.php");
    exit();
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hero_images WHERE id=$id"));

if($data && !empty($data['image'])){
    $file = "uploads/" . $data['image'];
    if(file_exists($file)){
        unlink($file);
    }
}

mysqli_query($conn, "DELETE FROM hero_images WHERE id=$id");

header("Location: hero_admin.php");
?>
