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

<style>
body{
    margin:0;
    font-family: Arial;
    background:#f4f4f4;
}

/* WRAPPER */
.news-strip-wrapper{
    padding:20px;
}

/* CAROUSEL CONTAINER */
.news-strip-grid{
    display:flex;
    gap:15px;
    overflow-x:auto;
    scroll-snap-type:x mandatory;
    -webkit-overflow-scrolling:touch;
    scroll-behavior:smooth;
}

/* hide scrollbar */
.news-strip-grid::-webkit-scrollbar{
    display:none;
}

/* COLUMN */
.news-column{
    flex:0 0 33.33%;
    display:flex;
    flex-direction:column;
    gap:12px;
    scroll-snap-align:start;
}

/* CARD */
.news-strip-card{
    display:flex;
    gap:10px;
    background:#fff;
    border-radius:12px;
    text-decoration:none;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
    transition:0.2s;
}

.news-strip-card:hover{
    transform:scale(1.02);
}

.strip-img{
    width:40%;
    min-width:90px;
}

.strip-img img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.strip-content{
    padding:8px;
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

/* MOBILE ADJUST */
@media(max-width:768px){
    .news-column{
        flex:0 0 85%;
    }
}
</style>
</head>

<body>

<div class="news-strip-wrapper">

    <div class="news-strip-grid" id="newsCarousel">

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

            <a href="news.php?slug=<?php echo $news_items[$i]['slug']; ?>" class="news-strip-card">

                <div class="strip-img">
                    <img src="admin/uploads/images/<?php echo $news_items[$i]['image']; ?>">
                </div>

                <div class="strip-content">
                    <h3><?php echo $news_items[$i]['title']; ?></h3>
                    <p>
                        <?php echo substr(strip_tags($news_items[$i]['description'] ?? ''), 0, 80) . '...'; ?>
                    </p>
                </div>

            </a>

            <?php endfor; ?>

        </div>
        <?php endfor; ?>

    </div>

</div>

<script>
const carousel = document.getElementById("newsCarousel");

let scrollAmount = 0;
let cardWidth = window.innerWidth * 0.85; // mobile column width approx
let autoScrollSpeed = 1; // px per frame
let isHovered = false;

/* AUTO SCROLL */
function autoScroll(){
    if(!isHovered){
        carousel.scrollLeft += autoScrollSpeed;

        // reset loop
        if(carousel.scrollLeft >= carousel.scrollWidth - carousel.clientWidth){
            carousel.scrollLeft = 0;
        }
    }
    requestAnimationFrame(autoScroll);
}
autoScroll();

/* PAUSE ON TOUCH / MOUSE */
carousel.addEventListener("mouseenter", () => isHovered = true);
carousel.addEventListener("mouseleave", () => isHovered = false);
carousel.addEventListener("touchstart", () => isHovered = true);
carousel.addEventListener("touchend", () => {
    setTimeout(()=> isHovered = false, 2000);
});
</script>

</body>
</html>