<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reels Grid</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#0f0f0f;
    color:white;
}

/* header */
.header{
    padding:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn-more{
    padding:10px 15px;
    background:#ff2d55;
    color:white;
    border:none;
    border-radius:8px;
    text-decoration:none;
}

/* grid */
.grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:5px;
    padding:10px;
}

.reel-box{
    position:relative;
    height:160px;
    overflow:hidden;
    border-radius:10px;
}

.reel-box video{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* overlay play icon */
.reel-box::after{
    content:"▶";
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    font-size:20px;
    color:white;
    background:rgba(0,0,0,0.5);
    padding:10px;
    border-radius:50%;
}

/* responsive */
@media(max-width:768px){
    .grid{
        grid-template-columns:repeat(3, 1fr);
    }
}

@media(max-width:480px){
    .grid{
        grid-template-columns:repeat(2, 1fr);
    }
}

</style>
</head>

<body>

<div class="header">
    <h2>🔥 Reels</h2>
    <a class="btn-more" href="reels.php">More Reels</a>
</div>

<div class="grid">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="reel-box">
    <video src="admin/<?php echo htmlspecialchars($row['video']); ?>"></video>
</div>

<?php } ?>

</div>

</body>
</html>