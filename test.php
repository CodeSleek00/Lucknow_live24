<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if(!$result){
    die(mysqli_error($conn));
}
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
}

.reels-container{
    height:100vh;
    overflow-y:scroll;
    scroll-snap-type:y mandatory;
}

.reel{
    height:100vh;
    position:relative;
    scroll-snap-align:start;
}

video{
    width:100%;
    height:100%;
    object-fit:cover;
}

.overlay{
    position:absolute;
    bottom:40px;
    left:20px;
    color:white;
    font-size:18px;
    font-weight:bold;
    text-shadow:0 2px 10px black;
}

.empty{
    color:white;
    text-align:center;
    margin-top:50vh;
}
</style>

</head>
<body>

<div class="reels-container">

<?php if(mysqli_num_rows($result) == 0){ ?>
    <div class="empty">No reels uploaded yet</div>
<?php } ?>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="reel">

    <!-- 🔥 FIXED PATH -->
    <video 
        src="admin/<?php echo htmlspecialchars($row['video']); ?>" 
        muted 
        loop 
        playsinline>
    </video>

    <div class="overlay">
        <?php echo htmlspecialchars($row['title']); ?>
    </div>

</div>

<?php } ?>

</div>

<script>
const videos = document.querySelectorAll('video');

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
</script>

</body>
</html>