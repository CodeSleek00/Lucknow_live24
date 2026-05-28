<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reels Section</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

.news-reel{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff2d55, #ff4d4d);
    padding: 20px;
}

.news-reel .header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.news-reel .header h2{
    color:white;
    font-size:20px;
}

.news-reel .btn-more{
    background:white;
    color:#ff2d55;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
}

.news-reel .grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:12px;
}

.news-reel .reel-box{
    background:white;
    border-radius:16px;
    overflow:hidden;
    position:relative;
    aspect-ratio: 9 / 16;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    cursor:pointer;
}

/* VIDEO */
.news-reel .reel-box video{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* PLAY ICON */
.news-reel .reel-box::after{
    content:"▶";
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    font-size:18px;
    color:white;
    background:rgba(0,0,0,0.5);
    width:45px;
    height:45px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    pointer-events:none;
    transition:0.3s;
}

/* hide icon when playing */
.news-reel .reel-box.playing::after{
    opacity:0;
}

@media(max-width:1024px){
    .news-reel .grid{
        grid-template-columns:repeat(3, 1fr);
    }
}
@media(max-width:600px){
    .news-reel .grid{
        grid-template-columns:repeat(2, 1fr);
    }

    /* Force only 4 visible items on mobile */
    .news-reel .reel-box:nth-child(n+5){
        display:none;
    }
}

</style>
</head>

<body>

<section class="news-reel">

    <div class="header">
        <h2>🔥 Reels</h2>
        <a class="btn-more" href="reels.php">More</a>
    </div>

    <div class="grid">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="reel-box">
            <video src="admin/<?php echo htmlspecialchars($row['video']); ?>" muted playsinline></video>
        </div>

        <?php } ?>

    </div>

</section>

<script>
// CLICK TO PLAY / PAUSE (Instagram style)

const reels = document.querySelectorAll('.news-reel .reel-box');

reels.forEach(box => {
    const video = box.querySelector('video');

    box.addEventListener('click', () => {

        // pause all other videos
        reels.forEach(b => {
            const v = b.querySelector('video');
            if (v !== video) {
                v.pause();
                b.classList.remove('playing');
            }
        });

        // toggle current
        if (video.paused) {
            video.play();
            box.classList.add('playing');
        } else {
            video.pause();
            box.classList.remove('playing');
        }
    });
});
</script>

</body>
</html>