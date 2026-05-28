<?php
include 'database_connection/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$query = "SELECT * FROM news ORDER BY id DESC LIMIT 5";
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

<!-- Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f4f4f4;
}

/* THEME */
:root{
    --accent:#e50914;
}

/* WRAPPER */
.news-wrapper{
    width:95%;
    max-width:1400px;
    margin:40px auto;
}

/* ================= DESKTOP GRID ================= */
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

/* ================= CARD DESIGN ================= */
.news-card{
    position:relative;
    border-radius:18px;
    overflow:hidden;
    text-decoration:none;
    color:white;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
    transition:0.3s ease;
    background:#000;
}

.news-card:hover{
    transform:translateY(-6px);
}

/* IMAGE */
.news-image{
    width:100%;
    aspect-ratio:16/9;
    object-fit:cover;
    display:block;
    filter:contrast(1.05) saturate(1.1);
}

/* 🔥 DARK GRADIENT OVER IMAGE */
.news-card::before{
    content:'';
    position:absolute;
    inset:0;
    background:linear-gradient(
        to top,
        rgba(0,0,0,0.75),
        rgba(0,0,0,0.2),
        rgba(0,0,0,0)
    );
    z-index:1;
}

/* ⬇️ WHITE FADE AT BOTTOM */
.news-card::after{
    content:'';
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    height:45%;
    background:linear-gradient(
        to top,
        rgba(255,255,255,0.95),
        rgba(255,255,255,0)
    );
    z-index:2;
}

/* CONTENT */
.news-content{
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    padding:18px;
    z-index:3;
}

/* TITLE */
.news-title{
    font-size:20px;
    font-weight:600;
    line-height:1.3;
    color:#111;
}

/* BIG CARD */
.first-row-card .news-title{
    font-size:26px;
}

/* RED BADGE */
.badge{
    position:absolute;
    top:12px;
    left:12px;
    background:var(--accent);
    color:white;
    padding:5px 10px;
    font-size:11px;
    border-radius:20px;
    z-index:4;
}

/* ================= MOBILE CAROUSEL ================= */
.mobile-carousel{
    display:none;
    position:relative;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.mobile-slide{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    opacity:0;
    transition:opacity 1s ease-in-out;
}

.mobile-slide.active{
    opacity:1;
    position:relative;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){

    .news-grid-first,
    .news-grid-second{
        display:none;
    }

    .mobile-carousel{
        display:block;
    }

    .news-title{
        font-size:18px;
    }
}

</style>
</head>

<body>

<div class="news-wrapper">

    <!-- DESKTOP -->
    <div class="news-grid-first">
        <?php for($i = 0; $i < 3 && $i < count($news_items); $i++): ?>
        <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card first-row-card">

            <div class="badge">Trending</div>

            <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>" class="news-image">

            <div class="news-content">
                <h2 class="news-title"><?php echo $news_items[$i]['title']; ?></h2>
            </div>

        </a>
        <?php endfor; ?>
    </div>

    <div class="news-grid-second">
        <?php for($i = 3; $i < 5 && $i < count($news_items); $i++): ?>
        <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card">

            <div class="badge">Latest</div>

            <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>" class="news-image">

            <div class="news-content">
                <h2 class="news-title"><?php echo $news_items[$i]['title']; ?></h2>
            </div>

        </a>
        <?php endfor; ?>
    </div>

    <!-- MOBILE CAROUSEL -->
    <div class="mobile-carousel" id="carousel">

        <?php foreach($news_items as $news): ?>
        <a href="news.php?slug=<?php echo $news['slug']; ?>" class="mobile-slide news-card">

            <div class="badge">Breaking</div>

            <img src="admin/uploads/images/<?php echo $news['image']; ?>" class="news-image">

            <div class="news-content">
                <h2 class="news-title"><?php echo $news['title']; ?></h2>
            </div>

        </a>
        <?php endforeach; ?>

    </div>

</div>

<script>
let slides = document.querySelectorAll('.mobile-slide');
let index = 0;

function showSlide(i){
    slides.forEach(s => s.classList.remove('active'));
    if(slides[i]) slides[i].classList.add('active');
}

if(slides.length > 0){
    showSlide(0);

    setInterval(() => {
        index = (index + 1) % slides.length;
        showSlide(index);
    }, 8000);
}
</script>

</body>
</html>