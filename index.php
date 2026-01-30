<?php
include 'admin/db_connect.php';

/* Fetch active breaking news */
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Breaking News | Live Updates</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<div class="breaking-wrapper">
    <div class="breaking-label">BREAKING NEWS</div>

    <div class="breaking-marquee">
        <div class="breaking-text">
            <?php
            if(count($news) > 0){
                foreach($news as $n){
                    echo "🔴 <span>$n</span>";
                }
            } else {
                echo "<span>No Breaking News Available</span>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>
