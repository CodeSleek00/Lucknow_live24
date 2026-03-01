<?php
include 'admin/db_connect.php';

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
.hero{
    position:relative;
    height:calc(100vh - 80px);
    min-height:420px;
    overflow:hidden;
}
.slide{
    position:absolute;
    width:100%;
    height:100%;
    opacity:0;
    transition:1s;
}
.slide img{
    width:100%;
    height:100%;
    object-fit:cover;
}
.active{
    opacity:1;
}

@media (max-width: 1024px){
    .hero{
        height:62vh;
        min-height:360px;
    }
}

@media (max-width: 768px){
    .breaking-wrapper{
        height:62px;
    }

    .hero{
        height:50vh;
        min-height:280px;
    }
}

@media (max-width: 480px){
    .hero{
        height:42vh;
        min-height:220px;
    }
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

<div class="hero">
<?php
$result = mysqli_query($conn,"SELECT * FROM hero_images ORDER BY id DESC");
$first=true;
while($row=mysqli_fetch_assoc($result)){
?>
<div class="slide <?php if($first){echo 'active'; $first=false;} ?>">
    <img src="admin/hero/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Hero Image">
</div>
<?php } ?>
</div>

<script>
const slides = document.querySelectorAll('.slide');
let i = 0;

if (slides.length > 1) {
    setInterval(() => {
        slides[i].classList.remove('active');
        i = (i + 1) % slides.length;
        slides[i].classList.add('active');
    }, 3000);
}
</script>


</body>
</html>
