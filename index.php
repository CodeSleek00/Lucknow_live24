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

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f3f3f3;
}

.news-wrapper{
    width:95%;
    max-width:1400px;
    margin:40px auto;
}

/* First row - 3 columns */
.news-grid-first{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:20px;
}

/* Second row - 2 columns (50% 50%) */
.news-grid-second{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.news-card{
    background:white;
    border-radius:14px;
    overflow:hidden;
    text-decoration:none;
    color:black;
    transition:0.3s;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.news-card:hover{
    transform:translateY(-5px);
}

.news-image{
    width:100%;
    height:240px;
    object-fit:cover;
}

.news-content{
    padding:15px;
}

.news-title{
    font-size:24px;
    font-weight:bold;
    line-height:1.4;
}

/* First row styles */
.first-row-card .news-image{
    height:390px;
}

.first-row-card .news-title{
    font-size:34px;
}

/* Second row styles - equal 50% width automatically */
.second-row-card .news-image{
    height:240px;
}

.second-row-card .news-title{
    font-size:24px;
}

@media(max-width:992px){
    .news-grid-first{
        grid-template-columns:repeat(2,1fr);
    }
    
    .news-grid-second{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:768px){
    .news-grid-first{
        display:flex;
        overflow-x:auto;
        gap:15px;
        padding-bottom:10px;
        scroll-snap-type:x mandatory;
    }
    
    .news-grid-second{
        display:flex;
        overflow-x:auto;
        gap:15px;
        padding-bottom:10px;
        scroll-snap-type:x mandatory;
    }
    
    .news-grid-first::-webkit-scrollbar,
    .news-grid-second::-webkit-scrollbar{
        height:5px;
    }
    
    .news-grid-first::-webkit-scrollbar-thumb,
    .news-grid-second::-webkit-scrollbar-thumb{
        background:#ccc;
        border-radius:20px;
    }
    
    .news-card{
        min-width:280px;
        flex-shrink:0;
        scroll-snap-align:start;
    }
    
    .first-row-card .news-image{
        height:250px;
    }
    
    .news-title{
        font-size:18px;
    }
    
    .first-row-card .news-title{
        font-size:22px;
    }
}

</style>
</head>
<body>

<div class="news-wrapper">

<!-- First Row: 3 Items -->
<div class="news-grid-first">
    <?php for($i = 0; $i < 3 && $i < count($news_items); $i++): ?>
        <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card first-row-card">
            <img src="admin/uploads/<?php echo $news_items[$i]['image']; ?>" class="news-image">
            <div class="news-content">
                <h2 class="news-title"><?php echo $news_items[$i]['title']; ?></h2>
            </div>
        </a>
    <?php endfor; ?>
</div>

<!-- Second Row: 2 Items (50% 50% width) -->
<div class="news-grid-second">
    <?php for($i = 3; $i < 5 && $i < count($news_items); $i++): ?>
        <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card second-row-card">
            <img src="admin/uploads/<?php echo $news_items[$i]['image']; ?>" class="news-image">
            <div class="news-content">
                <h2 class="news-title"><?php echo $news_items[$i]['title']; ?></h2>
            </div>
        </a>
    <?php endfor; ?>
</div>

</div>

</body>
</html>