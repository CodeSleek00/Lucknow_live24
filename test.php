<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Database error: " . mysqli_error($conn));
}

/*
IMPORTANT FIX:
Base URL ensures video loads correctly even in subfolders
*/
$base_url = "/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reels</title>

<link rel="stylesheet" href="style.css">

<style>
body {
    margin: 0;
    background: black;
    font-family: Arial, sans-serif;
}

.reels-container {
    height: 100vh;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
}

.reel {
    position: relative;
    height: 100vh;
    width: 100%;
    scroll-snap-align: start;
    display: flex;
    justify-content: center;
    align-items: center;
}

.video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    background: black;
}

.overlay {
    position: absolute;
    bottom: 40px;
    left: 20px;
    color: white;
    font-size: 18px;
    font-weight: bold;
    text-shadow: 0 2px 10px rgba(0,0,0,0.8);
    z-index: 2;
    max-width: 80%;
}

/* empty state */
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

    <video 
        class="video" 
        src="<?php echo $base_url . htmlspecialchars($row['video']); ?>" 
        muted 
        loop
        playsinline
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