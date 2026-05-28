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
$paragraphs = json_decode($data['paragraphs'] ?? '[]', true);

$imageIndex = 0;
$videoIndex = 0;

function getImage(&$images, &$imageIndex){
    if(isset($images[$imageIndex])){
        return $images[$imageIndex++];
    }
    return null;
}

function getVideo(&$videos, &$videoIndex){
    if(isset($videos[$videoIndex])){
        return $videos[$videoIndex++];
    }
    return null;
}
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
    max-width:900px;
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
    font-size:40px;
    margin-bottom:10px;
}

/* DATE */
.date{
    color:gray;
    margin-bottom:20px;
}

/* DESCRIPTION */
.description{
    font-size:18px;
    line-height:1.8;
    margin-bottom:25px;
    color:#333;
}

/* PARAGRAPH */
.paragraph{
    font-size:17px;
    line-height:1.8;
    margin-bottom:25px;
    color:#222;
}

/* MEDIA */
.media-img{
    width:100%;
    border-radius:12px;
    margin:15px 0 30px;
}

video{
    width:100%;
    border-radius:12px;
    margin:15px 0 30px;
}

/* MOBILE */
@media(max-width:768px){
    h1{font-size:26px;}
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
<div class="description">
<?php echo nl2br($data['description']); ?>
</div>

<!-- =========================
     DYNAMIC CONTENT FLOW
========================= -->
<?php if(!empty($paragraphs)){ ?>

    <?php foreach($paragraphs as $index => $para){ ?>

        <!-- PARAGRAPH -->
        <div class="paragraph">
            <?php echo nl2br($para); ?>
        </div>

        <!-- IMAGE after paragraph -->
        <?php 
        $img = getImage($images, $imageIndex);
        if($img){ ?>
            <img class="media-img" src="admin/uploads/images/<?php echo $img; ?>">
        <?php } ?>

        <!-- VIDEO after paragraph -->
        <?php 
        $vid = getVideo($videos, $videoIndex);
        if($vid){ ?>
            <video controls>
                <source src="admin/uploads/videos/<?php echo $vid; ?>" type="video/mp4">
            </video>
        <?php } ?>

    <?php } ?>

<?php } ?>

</div>

</body>
</html>