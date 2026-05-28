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

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family: 'Poppins', sans-serif;
    background:#f5f6fa;
}

/* WRAPPER */
.news-wrapper{
    padding:20px;
}

/* CAROUSEL */
.news-carousel{
    display:flex;
    gap:16px;
    overflow-x:auto;
    scroll-snap-type:x mandatory;
    -webkit-overflow-scrolling:touch;
    scroll-behavior:smooth;
    padding-bottom:10px;
}

.news-carousel::-webkit-scrollbar{
    display:none;
}

/* COLUMN */
.news-column{
    flex:0 0 32%;
    min-width:320px;
    display:flex;
    flex-direction:column;
    gap:12px;
    scroll-snap-align:start;
}

/* CARD */
.news-card{
    display:flex;
    flex-direction:column;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
    transition:0.25s ease;
}

.news-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 28px rgba(0,0,0,0.12);
}

/* IMAGE - FIXED LANDSCAPE SIZE */
.news-img{
    width:100%;
    aspect-ratio:16/9;   /* IMPORTANT: uniform landscape */
    overflow:hidden;
}

.news-img img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

/* CONTENT */
.news-content{
    padding:12px;
}

.news-title{
    font-size:14px;
    font-weight:600;
    color:#111;
    margin:0;
    line-height:1.4;
}

.news-desc{
    font-size:12px;
    color:#666;
    margin-top:6px;
    line-height:1.5;
}

/* RESPONSIVE */
@media(max-width:1024px){
    .news-column{
        flex:0 0 45%;
    }
}

@media(max-width:768px){
    .news-column{
        flex:0 0 85%;
    }

    .news-title{
        font-size:15px;
    }
}

@media(max-width:480px){
    .news-column{
        flex:0 0 90%;
    }
}
</style>
</head>

<body>

<div class="news-wrapper">

    <div class="news-carousel">

        <?php
        $total = count($news_items);
        $perCol = 3;
        $cols = ceil($total / $perCol);

        for ($col = 0; $col < $cols; $col++):
        ?>
        <div class="news-column">

            <?php for ($row = 0; $row < 3; $row++):
                $i = ($col * 3) + $row;
                if ($i >= $total) break;
            ?>

            <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card">

                <div class="news-img">
                    <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>">
                </div>

                <div class="news-content">
                    <h3 class="news-title">
                        <?php echo $news_items[$i]['title']; ?>
                    </h3>

                    <p class="news-desc">
                        <?php echo substr(strip_tags($news_items[$i]['description'] ?? ''), 0, 95) . '...'; ?>
                    </p>
                </div>

            </a>

            <?php endfor; ?>

        </div>
        <?php endfor; ?>

    </div>

</div>

</body>
</html>