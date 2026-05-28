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

<title>Lucknow Live 24x7</title>

<!-- Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<link rel="stylesheet" href="style.css?v=1.2">

<style>
body{
    margin:0;
    font-family:'Poppins', sans-serif;
    background:#f4f4f4;
}

/* ================= STRIP SECTION ================= */
.news-strip-wrapper{
    padding:20px;
}

.news-strip-grid{
    display:flex;
    gap:15px;
    overflow-x:auto;
    scroll-snap-type:x mandatory;
    scroll-behavior:smooth;
}

.news-strip-grid::-webkit-scrollbar{
    display:none;
}

.news-column{
    flex:0 0 33.33%;
    display:flex;
    flex-direction:column;
    gap:12px;
    scroll-snap-align:start;
}

.news-card{
    display:flex;
    gap:10px;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:0 4px 14px rgba(0,0,0,0.08);
    transition:0.2s;
}

.news-card:hover{
    transform:translateY(-3px);
}

.news-img{
    width:40%;
    aspect-ratio:16/9;
    overflow:hidden;
}

.news-img img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.news-content{
    padding:10px;
    width:60%;
}

.news-content h3{
    font-size:13px;
    margin:0;
    color:#111;
}

.news-content p{
    font-size:11px;
    color:#666;
    margin-top:5px;
}

/* ================= REELS ================= */
.news-reel{
    padding:20px;
}

.news-reel .header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.reel-box video{
    width:100%;
    border-radius:10px;
}

/* ================= MOBILE ================= */
@media(max-width:768px){
    .news-column{
        flex:0 0 85%;
    }
}
</style>
</head>

<body>

<!-- ================= NAVBAR (YOUR EXISTING) ================= -->
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

<!-- ================= STRIP NEWS (3x3 CAROUSEL) ================= -->
<div class="news-strip-wrapper">

    <div class="news-strip-grid">

        <?php
        $total = count($news_items);
        $perCol = 3;
        $cols = ceil($total / $perCol);

        for($col = 0; $col < $cols; $col++):
        ?>
        <div class="news-column">

            <?php for($row = 0; $row < 3; $row++):
                $i = ($col * 3) + $row;
                if($i >= $total) break;
            ?>

            <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-card">

                <div class="news-img">
                    <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>">
                </div>

                <div class="news-content">
                    <h3><?php echo $news_items[$i]['title']; ?></h3>
                    <p><?php echo substr(strip_tags($news_items[$i]['description'] ?? ''),0,80).'...'; ?></p>
                </div>

            </a>

            <?php endfor; ?>

        </div>
        <?php endfor; ?>

    </div>

</div>

<!-- ================= REELS ================= -->
<section class="news-reel">

    <div class="header">
        <h2>News Reels</h2>
        <a href="reels.php">More</a>
    </div>

    <div class="grid">

        <?php while($row = mysqli_fetch_assoc($reels_result)) { ?>
        <div class="reel-box">
            <video src="admin/<?php echo htmlspecialchars($row['video']); ?>" playsinline controls></video>
        </div>
        <?php } ?>

    </div>

</section>

<script src="script.js?v=1.2"></script>

</body>
</html>