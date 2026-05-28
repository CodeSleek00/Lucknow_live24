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
<title>News Section</title>

<style>
body{
    margin:0;
    font-family: Arial, sans-serif;
    background:#f4f4f4;
}

/* MAIN WRAPPER */
.news-strip-wrapper{
    width:100%;
    padding:20px;
    box-sizing:border-box;
}

/* ===== DESKTOP GRID ===== */
.news-strip-grid{
    display:flex;
    gap:15px;
}

/* 3 columns */
.news-column{
    flex:1;
    display:flex;
    flex-direction:column;
    gap:12px;
}

/* STRIP CARD */
.news-strip-card{
    display:flex;
    gap:12px;
    text-decoration:none;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
    transition:0.2s ease;
}

.news-strip-card:hover{
    transform:scale(1.02);
}

.strip-img{
    width:40%;
    min-width:110px;
}

.strip-img img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.strip-content{
    padding:10px;
    width:60%;
}

.strip-content h3{
    font-size:14px;
    margin:0;
    color:#111;
    line-height:1.3;
}

.strip-content p{
    font-size:12px;
    color:#555;
    margin-top:6px;
}

/* ===== MOBILE CAROUSEL ===== */
.news-carousel{
    display:none;
    overflow-x:auto;
    gap:12px;
    scroll-snap-type:x mandatory;
    -webkit-overflow-scrolling:touch;
    padding-bottom:10px;
}

.carousel-card{
    min-width:80%;
    flex:0 0 auto;
    scroll-snap-align:start;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 12px rgba(0,0,0,0.1);
    text-decoration:none;
}

.carousel-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.carousel-content{
    padding:10px;
}

.carousel-content h3{
    font-size:15px;
    margin:0;
    color:#111;
}

.carousel-content p{
    font-size:12px;
    color:#555;
    margin-top:5px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .news-strip-grid{
        display:none;
    }

    .news-carousel{
        display:flex;
    }
}
</style>
</head>

<body>

<div class="news-strip-wrapper">

    <!-- ================= DESKTOP ================= -->
    <div class="news-strip-grid">

        <?php
        $total = count($news_items);
        $perCol = 3;
        $cols = 3;

        for ($col = 0; $col < $cols; $col++):
        ?>
        <div class="news-column">

            <?php
            for ($row = 0; $row < $perCol; $row++):
                $i = ($col * $perCol) + $row;
                if ($i >= $total) break;
            ?>

            <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-strip-card">

                <div class="strip-img">
                    <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>">
                </div>

                <div class="strip-content">
                    <h3><?php echo $news_items[$i]['title']; ?></h3>
                    <p>
                        <?php 
                        echo substr(strip_tags($news_items[$i]['content'] ?? 'Latest update available...'), 0, 90) . '...'; 
                        ?>
                    </p>
                </div>

            </a>

            <?php endfor; ?>

        </div>
        <?php endfor; ?>

    </div>


    <!-- ================= MOBILE ================= -->
    <div class="news-carousel">

        <?php foreach($news_items as $item): ?>

        <a href="news.php?slug=<?php echo $item['slug']; ?>" class="carousel-card">

            <img src="admin/uploads/images/<?php echo $item['image']; ?>">

            <div class="carousel-content">
                <h3><?php echo $item['title']; ?></h3>
                <p>
                    <?php echo substr(strip_tags($item['content'] ?? ''), 0, 80) . '...'; ?>
                </p>
            </div>

        </a>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>