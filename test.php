<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Database error: " . mysqli_error($conn));
}

/*
IMPORTANT:
This prevents 404 issues caused by relative paths.
We always force root-based URL.
*/
$base_url = "/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reels</title>

<style>
body {
    margin: 0;
    background: black;
    font-family: Arial, sans-serif;
}

/* FULL SCREEN REELS CONTAINER */
.reels-container {
    height: 100vh;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
}

/* EACH REEL */
.reel {
    position: relative;
    height: 100vh;
    width: 100%;
    scroll-snap-align: start;
    display: flex;
    justify-content: center;
    align-items: center;
    background: black;
}

/* VIDEO STYLE */
.video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* TITLE OVERLAY */
.overlay {
    position: absolute;
    bottom: 50px;
    left: 20px;
    color: white;
    font-size: 18px;
    font-weight: bold;
    text-shadow: 0px 2px 10px rgba(0,0,0,0.8);
    max-width: 80%;
}

/* EMPTY STATE */
.empty {
    color: white;
    text-align: center;
    margin-top: 50vh;
    transform: translateY(-50%);
    font-size: 20px;
}
</style>

</head>
<body>

<div class="reels-container">

<?php
if(mysqli_num_rows($result) == 0){
    echo "<div class='empty'>No reels uploaded yet</div>";
}

while($row = mysqli_fetch_assoc($result)) {
?>

<div class="reel">

    <!-- FIXED VIDEO PATH (THIS SOLVES YOUR 404 ISSUE) -->
    <video 
        class="video"
        src="<?php echo $base_url . htmlspecialchars($row['video']); ?>"
        muted
        loop
        playsinline
        preload="metadata"
    ></video>

    <div class="overlay">
        <?php echo htmlspecialchars($row['title']); ?>
    </div>

</div>

<?php } ?>

</div>

<script>
/*
AUTO PLAY / PAUSE LIKE INSTAGRAM REELS
*/
const videos = document.querySelectorAll('.video');

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.play().catch(err => {});
        } else {
            entry.target.pause();
        }
    });
}, { threshold: 0.7 });

videos.forEach(video => {
    observer.observe(video);
});
</script>

</body>
</html>