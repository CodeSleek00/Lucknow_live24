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
if($id > 0){
    mysqli_query($conn, "UPDATE news_posts SET status = IF(status=1,0,1) WHERE id=$id");
}

header("Location: news_admin.php");
