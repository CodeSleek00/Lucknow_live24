<?php
include 'db_connect.php';

$id = intval($_GET['id']);

mysqli_query($conn, "
    UPDATE breaking_news 
    SET status = IF(status=1,0,1) 
    WHERE id=$id
");

header("Location: admin_manage_breaking.php");
?>
