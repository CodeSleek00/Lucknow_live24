<?php
include 'database_connection/db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

/* ================= NEWS ================= */
$news_query = "SELECT * FROM news ORDER BY id DESC LIMIT 30";
$news_result = mysqli_query($conn, $news_query);

$news_items = [];
while($row = mysqli_fetch_assoc($news_result)) {
    $news_items[] = $row;
}

/* ================= REELS ================= */
$reels_query = "SELECT * FROM reels ORDER BY id DESC LIMIT 5";
$reels_result = mysqli_query($conn, $reels_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lucknow Live 24X7</title>

<link rel="stylesheet" href="style.css?v=1.2">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

</head>

<body>

<!-- ================= NAVBAR (UNCHANGED) ================= -->
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
        <button class="icon-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button class="icon-btn"><i class="fa-regular fa-bell"></i></button>
        <button class="live-btn"><div class="live-dot"></div>LIVE</button>
    </div>

</nav>

<!-- ================= NEWS SECTION (UNCHANGED) ================= -->
<div class="news-wrapper">

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

    <!-- ================= MOBILE CAROUSEL (UNCHANGED) ================= -->
    <div class="mobile-carousel" id="carousel">

        <?php foreach($news_items as $news): ?>
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

<!-- ================= REELS (UNCHANGED FIXED) ================= -->
<section class="news-reel">

    <div class="header">
        <h2>News Reels</h2>
        <a class="btn-more" href="reels.php">More</a>
    </div>

    <div class="grid">

        <?php while($row = mysqli_fetch_assoc($reels_result)) { ?>

        <div class="reel-box">
            <video src="admin/<?php echo htmlspecialchars($row['video']); ?>" playsinline></video>
        </div>

        <?php } ?>

    </div>

</section>

<!-- ================= 🔥 NEW 3x3 STRIP SECTION (ONLY ADDITION) ================= -->

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
.strip-wrapper{
    padding:20px;
    font-family:'Poppins', sans-serif;
}

.strip-grid{
    display:flex;
    gap:15px;
    overflow-x:auto;
    scroll-snap-type:x mandatory;
    -webkit-overflow-scrolling:touch;
    scroll-behavior:smooth;
}

.strip-grid::-webkit-scrollbar{
    display:none;
}

.strip-column{
    flex:0 0 33.33%;
    display:flex;
    flex-direction:column;
    gap:12px;
    scroll-snap-align:start;
}

.strip-card{
    display:flex;
    gap:10px;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:0 4px 14px rgba(0,0,0,0.08);
    transition:0.2s;
}

.strip-card:hover{
    transform:translateY(-3px);
}

.strip-img{
    width:40%;
    aspect-ratio:16/9;
    overflow:hidden;
}

.strip-img img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.strip-content{
    padding:10px;
    width:60%;
}

.strip-content h3{
    font-size:13px;
    margin:0;
    color:#111;
}

.strip-content p{
    font-size:11px;
    color:#666;
    margin-top:5px;
}

@media(max-width:768px){
    .strip-column{
        flex:0 0 85%;
    }
}
</style>

<div class="strip-wrapper">

    <div class="strip-grid">

        <?php
        $total = count($news_items);
        $perCol = 3;
        $cols = ceil($total / $perCol);

        for($col = 0; $col < $cols; $col++):
        ?>
        <div class="strip-column">

            <?php for($row = 0; $row < 3; $row++):
                $i = ($col * 3) + $row;
                if($i >= $total) break;
            ?>

            <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="strip-card">

                <div class="strip-img">
                    <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>">
                </div>

                <div class="strip-content">
                    <h3><?php echo $news_items[$i]['title']; ?></h3>
                    <p><?php echo substr(strip_tags($news_items[$i]['description'] ?? ''),0,80).'...'; ?></p>
                </div>

            </a>

            <?php endfor; ?>

        </div>
        <?php endfor; ?>

    </div>

</div>

<!-- ================= SCRIPT ================= -->
<script src="script.js?v=1.2"></script>

</body>
</html>