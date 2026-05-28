<?php
include 'database_connection/db.php';

$query = "SELECT * FROM news ORDER BY id DESC LIMIT 30";
$result = mysqli_query($conn, $query);

$news_items = [];
while($row = mysqli_fetch_assoc($result)) {
    $news_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>News Carousel</title>

<style>
body{
    margin:0;
    font-family: Arial;
    background:#f4f4f4;
}

</style>
</head>

<body>

</body>
</html>