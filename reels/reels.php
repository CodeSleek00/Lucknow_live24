<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reels</title>

<style>
body{
    margin:0;
    background:black;
    font-family:Arial;
    overflow:hidden;
}

/* container */
.reels-container{
    height:100vh;
    overflow-y:scroll;
    scroll-snap-type:y mandatory;
}

/* reel */
.reel{
    height:100vh;
    position:relative;
    scroll-snap-align:start;
}

/* video */
video{
    width:100%;
    height:100%;
    object-fit:cover;
    background:black;
}

/* bottom info */
.overlay{
    position:absolute;
    bottom:90px;
    left:15px;
    color:white;
    font-size:16px;
    font-weight:600;
    text-shadow:0 2px 10px black;
}

/* controls */
.controls{
    position:absolute;
    right:15px;
    bottom:120px;
    display:flex;
    flex-direction:column;
    gap:15px;
}

.btn{
    width:45px;
    height:45px;
    border-radius:50%;
    background:rgba(0,0,0,0.6);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:18px;
    cursor:pointer;
}

/* top bar */
.topbar{
    position:absolute;
    top:15px;
    left:15px;
    right:15px;
    display:flex;
    justify-content:space-between;
    color:white;
    z-index:10;
}

.topbar a{
    color:white;
    text-decoration:none;
    font-weight:bold;
}

</style>
</head>

<body>

<div class="reels-container">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="reel">

    <div class="topbar">
        <a href="reels_grid.php">⬅ Back</a>
        <a href="#">Reels</a>
    </div>

    <video 
        src="admin/<?php echo htmlspecialchars($row['video']); ?>" 
        muted 
        loop 
        playsinline>
    </video>

    <div class="overlay">
        <?php echo htmlspecialchars($row['title']); ?>
    </div>

    <div class="controls">

        <!-- mute -->
        <div class="btn muteBtn">🔊</div>

        <!-- share -->
        <div class="btn shareBtn">🔗</div>

    </div>

</div>

<?php } ?>

</div>

<script>
const videos = document.querySelectorAll('video');

/* auto play like insta */
const observer = new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
        if(entry.isIntersecting){
            entry.target.play().catch(()=>{});
        } else {
            entry.target.pause();
        }
    });
},{threshold:0.7});

videos.forEach(v=>observer.observe(v));

/* mute toggle */
document.querySelectorAll('.muteBtn').forEach((btn, i)=>{
    btn.addEventListener('click', ()=>{
        const video = btn.closest('.reel').querySelector('video');
        video.muted = !video.muted;
        btn.innerHTML = video.muted ? "🔊" : "🔇";
    });
});

/* share button */
document.querySelectorAll('.shareBtn').forEach((btn)=>{
    btn.addEventListener('click', async ()=>{
        const reel = btn.closest('.reel');
        const video = reel.querySelector('video').src;

        if(navigator.share){
            try{
                await navigator.share({
                    title: "Check this reel",
                    url: video
                });
            } catch(e){}
        } else {
            navigator.clipboard.writeText(video);
            alert("Link copied!");
        }
    });
});
</script>

</body>
</html>