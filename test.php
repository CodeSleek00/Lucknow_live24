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

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

/* MAIN SECTION */
.news-reel{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ff2d55, #ff4d4d);
    padding: 20px;
}

/* HEADER */
.news-reel .header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.news-reel .header h2{
    color:white;
    font-size:20px;
    font-weight:600;
}

.news-reel .btn-more{
    background:white;
    color:#ff2d55;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-weight:500;
    font-size:13px;
    transition:0.3s;
}

.news-reel .btn-more:hover{
    background:#ffe6ea;
}

/* GRID */
.news-reel .grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:12px;
}

/* REEL CARD */
.news-reel .reel-box{
    background:white;
    border-radius:16px;
    overflow:hidden;
    position:relative;
    aspect-ratio: 9 / 16;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}

.news-reel .reel-box:hover{
    transform: scale(1.03);
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
    width:40px;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
}

/* TABLET */
@media(max-width:1024px){
    .news-reel .grid{
        grid-template-columns:repeat(3, 1fr);
    }
}

/* MOBILE */
@media(max-width:600px){
    .news-reel{
        padding:15px;
    }

    .news-reel .grid{
        grid-template-columns:repeat(2, 1fr);
        gap:10px;
    }

    .news-reel .header h2{
        font-size:18px;
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
            <video src="admin/<?php echo htmlspecialchars($row['video']); ?>" muted></video>
        </div>

        <?php } ?>

    </div>

</section>

</body>
</html>