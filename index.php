<?php
include 'db_connect.php';

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

<style>
body{
    margin:0;
    background:#000;
    font-family:Arial, sans-serif;
}

/* MAIN BAR */
.breaking-wrapper{
    width:100%;
    height:80px;
    background:#c40000;
    display:flex;
    align-items:center;
    overflow:hidden;
}

/* LABEL */
.breaking-label{
    background:#000;
    color:#fff;
    padding:0 30px;
    height:100%;
    display:flex;
    align-items:center;
    font-size:22px;
    font-weight:bold;
    letter-spacing:1px;
}

/* MARQUEE AREA */
.breaking-marquee{
    overflow:hidden;
    white-space:nowrap;
    width:100%;
}

/* MOVING TEXT */
.breaking-text{
    display:inline-block;
    padding-left:100%;
    font-size:22px;
    color:white;
    animation: scrollNews 22s linear infinite;
}

.breaking-text span{
    margin:0 25px;
}

/* ANIMATION */
@keyframes scrollNews{
    0%   { transform:translateX(0); }
    100% { transform:translateX(-100%); }
}

/* MOBILE */
@media(max-width:768px){
    .breaking-label{ font-size:16px; padding:0 15px; }
    .breaking-text{ font-size:16px; }
}
</style>
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
