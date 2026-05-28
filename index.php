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
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>


</head>

<body>

<nav class="navbar">

    <div class="logo">

       
        <h2>Lucknow<span> Live 24X7</span></h2>

    </div>

    <div class="nav-links">
        <a href="#">Home</a>
        <a href="#">Politics</a>
        <a href="#">Crime</a>
        <a href="#">Sports</a>
        <a href="#">Business</a>
        <a href="#">Tech</a>
    </div>

    <div class="nav-right">

        <button class="icon-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

        <button class="icon-btn">
            <i class="fa-regular fa-bell"></i>
        </button>

        <button class="live-btn">
            <div class="live-dot"></div>
            LIVE
        </button>

    </div>

    <button class="menu-btn" id="menuBtn">
        <i class="fa-solid fa-bars"></i>
    </button>

</nav>


<!-- MOBILE MENU -->

<div class="overlay" id="overlay"></div>

<div class="mobile-menu" id="mobileMenu">

    <div class="mobile-top">

        <h2>Lucknow<span>Live</span></h2>

        <button class="close-btn" id="closeBtn">
            <i class="fa-solid fa-xmark"></i>
        </button>

    </div>

    <div class="mobile-links">

        <a href="#">
            <i class="fa-solid fa-house"></i>
            Home
        </a>

        <a href="#">
            <i class="fa-solid fa-landmark"></i>
            Politics
        </a>

        <a href="#">
            <i class="fa-solid fa-shield-halved"></i>
            Crime
        </a>

        <a href="#">
            <i class="fa-solid fa-football"></i>
            Sports
        </a>

        <a href="#">
            <i class="fa-solid fa-chart-line"></i>
            Business
        </a>

        <a href="#">
            <i class="fa-solid fa-microchip"></i>
            Technology
        </a>

        <a href="#">
            <i class="fa-solid fa-circle-play"></i>
            Live TV
        </a>

    </div>

</div>

<!-- MOBILE BOTTOM NAV -->

<div class="bottom-nav">

    <a href="#" class="bottom-item ">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>

    <a href="#" class="bottom-item">
        <i class="fa-solid fa-video"></i>
        <span>Live</span>
    </a>

    <a href="#" class="bottom-item">
        <i class="fa-solid fa-fire"></i>
        <span>Trending</span>
    </a>

    <a href="#" class="bottom-item">
        <i class="fa-regular fa-bookmark"></i>
        <span>Saved</span>
    </a>

    <a href="#" class="bottom-item">
        <i class="fa-regular fa-user"></i>
        <span>Profile</span>
    </a>

</div>


<div class="news-wrapper">

    <!-- DESKTOP GRID -->
    <div class="news-grid-first">
        <?php for($i = 0; $i < 3 && $i < count($news_items); $i++): ?>
        <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card first-row-card">

            <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>" class="news-image">

            <div class="news-content">
                <h2 class="news-title"><?php echo $news_items[$i]['title']; ?></h2>
            </div>

        </a>
        <?php endfor; ?>
    </div>

    <div class="news-grid-second">
        <?php for($i = 3; $i < 5 && $i < count($news_items); $i++): ?>
        <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card second-row-card">

            <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>" class="news-image">

            <div class="news-content">
                <h2 class="news-title"><?php echo $news_items[$i]['title']; ?></h2>
            </div>

        </a>
        <?php endfor; ?>
    </div>

    <!-- MOBILE CAROUSEL -->
    <div class="mobile-carousel" id="carousel">

        <?php foreach($news_items as $index => $news): ?>
        <a href="news.php?slug=<?php echo $news['slug']; ?>" class="mobile-slide">

            <div class="badge">Breaking</div>

            <img src="admin/uploads/images/<?php echo $news['image']; ?>" class="news-image">

            <div class="news-content">
                <h2 class="news-title"><?php echo $news['title']; ?></h2>
            </div>

        </a>
        <?php endforeach; ?>

    </div>

</div>
<script src="script.js"></script>


</body>
</html>