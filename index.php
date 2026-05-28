<?php
include 'database_connection/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$query = "SELECT * FROM news ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $query);

// Store results in array
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

<title>News Section</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

body{
    background:#f3f3f3;
}

/* WRAPPER */
.news-wrapper{
    width:95%;
    max-width:1400px;
    margin:40px auto;
}

/* GRID LAYOUT */
.news-grid-first{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:20px;
}

.news-grid-second{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

/* NEWS CARD */
.news-card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    text-decoration:none;
    color:black;
    transition:0.3s ease;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.news-card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}

/* 🔥 IMAGE FIX - MAIN SOLUTION */
.news-image{
    width:100%;
    aspect-ratio:16/9;   /* STANDARD LANDSCAPE RATIO */
    object-fit:cover;    /* crop but no distortion */
    display:block;
}

/* CONTENT */
.news-content{
    padding:15px;
}

.news-title{
    font-size:22px;
    font-weight:bold;
    line-height:1.4;
}

/* FIRST ROW BIG CARD */
.first-row-card .news-title{
    font-size:30px;
}

/* SECOND ROW NORMAL CARD */
.second-row-card .news-title{
    font-size:20px;
}

/* RESPONSIVE */
@media(max-width:992px){
    .news-grid-first{
        grid-template-columns:repeat(2,1fr);
    }

    .news-grid-second{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:768px){

    .news-grid-first,
    .news-grid-second{
        display:flex;
        overflow-x:auto;
        gap:15px;
        padding-bottom:10px;
        scroll-snap-type:x mandatory;
    }

    .news-card{
        min-width:280px;
        flex-shrink:0;
        scroll-snap-align:start;
    }

    .news-title{
        font-size:18px;
    }

    .first-row-card .news-title{
        font-size:20px;
    }
}

</style>
</head>

<body>

<div class="news-wrapper">

    <!-- FIRST ROW (3 BIG NEWS) -->
    <div class="news-grid-first">

        <?php for($i = 0; $i < 3 && $i < count($news_items); $i++): ?>
            <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card first-row-card">

                <img 
                    src="admin/uploads/images<?php echo $news_items[$i]['image']; ?>" 
                    class="news-image"
                    alt="news image"
                >

                <div class="news-content">
                    <h2 class="news-title">
                        <?php echo $news_items[$i]['title']; ?>
                    </h2>
                </div>

            </a>
        <?php endfor; ?>

    </div>

    <!-- SECOND ROW (2 NEWS) -->
    <div class="news-grid-second">

        <?php for($i = 3; $i < 5 && $i < count($news_items); $i++): ?>
            <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card second-row-card">

                <img 
                    src="admin/uploads/images<?php echo $news_items[$i]['image']; ?>" 
                    class="news-image"
                    alt="news image"
                >

                <div class="news-content">
                    <h2 class="news-title">
                        <?php echo $news_items[$i]['title']; ?>
                    </h2>
                </div>

            </a>
        <?php endfor; ?>

    </div>

</div>

</body>
</html>