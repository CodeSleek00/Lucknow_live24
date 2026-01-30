<?php
include 'db_connect.php';

$news = mysqli_real_escape_string($conn, $_POST['news_text']);

mysqli_query($conn, "INSERT INTO breaking_news (news_text) VALUES ('$news')");

header("Location: admin_add_breaking.php");
?>
