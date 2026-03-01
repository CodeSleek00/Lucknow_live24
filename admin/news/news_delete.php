<?php
session_start();
include "../db_connect.php";
include "news_helpers.php";

if(!isset($_SESSION['admin'])){
    header("Location: ../admin_login.php");
    exit();
}

ensure_news_schema($conn);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0){
    header("Location: news_admin.php");
    exit();
}

$uploadDir = __DIR__ . '/uploads';
$mediaResult = mysqli_query($conn, "SELECT file_name FROM news_media WHERE post_id=$id");
while($media = mysqli_fetch_assoc($mediaResult)){
    $filePath = $uploadDir . '/' . $media['file_name'];
    if(file_exists($filePath)){
        unlink($filePath);
    }
}

mysqli_query($conn, "DELETE FROM news_media WHERE post_id=$id");
mysqli_query($conn, "DELETE FROM news_posts WHERE id=$id");

header("Location: news_admin.php?msg=" . urlencode("Post deleted."));
