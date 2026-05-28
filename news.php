<?php
include 'database_connection/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$slug = $_GET['slug'] ?? '';

$query = "SELECT * FROM news WHERE slug='$slug'";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

if(!$data){
    echo "News not found";
    exit;
}

// Decode JSON
$images = json_decode($data['images'] ?? '[]', true);
$videos = json_decode($data['videos'] ?? '[]', true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo $data['title']; ?></title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f5f5f5;
}

.container{
    width:90%;
    max-width:1000px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
}

/* MAIN IMAGE */
.main-img{
    width:100%;
    border-radius:12px;
    margin-bottom:20px;
}

/* TITLE */
h1{
    font-size:42px;
    margin-bottom:15px;
}

/* DATE */
.date{
    color:gray;
    margin-bottom:20px;
}

/* DESCRIPTION */
p{
    font-size:18px;
    line-height:1.8;
    color:#333;
}

/* GALLERY */
.gallery{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
    gap:10px;
    margin-top:30px;
}

.gallery img{
    width:100%;
    border-radius:10px;
}

/* VIDEOS */
.video-box{
    margin-top:30px;
}

video{
    width:100%;
    border-radius:12px;
    margin-bottom:15px;
}

/* MOBILE */
@media(max-width:768px){

    h1{
        font-size:28px;
    }

    p{
        font-size:16px;
    }
}

</style>
</head>
<body>

<div class="container">

<!-- MAIN IMAGE -->
<?php if(!empty($data['image'])){ ?>
    <img class="main-img" src="admin/uploads/images/<?php echo $data['image']; ?>">
<?php } ?>

<!-- TITLE -->
<h1><?php echo $data['title']; ?></h1>

<!-- DATE -->
<div class="date">
Published: <?php echo date("d M Y", strtotime($data['created_at'])); ?>
</div>

<!-- DESCRIPTION -->
<p><?php echo nl2br($data['description']); ?></p>

<!-- GALLERY IMAGES -->
<?php if(!empty($images)){ ?>
    <h3 style="margin-top:30px;">Gallery</h3>

    <div class="gallery">
        <?php foreach($images as $img){ ?>
            <img src="admin/uploads/images/<?php echo $img; ?>">
        <?php } ?>
    </div>
<?php } ?>

<!-- VIDEOS -->
<?php if(!empty($videos)){ ?>
    <h3 style="margin-top:30px;">Videos</h3>

    <div class="video-box">
        <?php foreach($videos as $vid){ ?>
            <video controls>
                <source src="uploads/videos/<?php echo $vid; ?>" type="video/mp4">
            </video>
        <?php } ?>
    </div>
<?php } ?>

</div>

</body>
</html>