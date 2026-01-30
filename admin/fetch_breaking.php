<?php
include 'db_connect.php';

$q = mysqli_query($conn, "
    SELECT news_text 
    FROM breaking_news 
    WHERE status = 1 
    ORDER BY id DESC
");

$news = [];
while($row = mysqli_fetch_assoc($q)){
    $news[] = $row['news_text'];
}

echo json_encode($news);
?>
