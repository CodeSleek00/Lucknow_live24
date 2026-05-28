<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Reels</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="reels-container">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="reel">

    <video class="video" src="<?php echo $row['video']; ?>" muted loop></video>

    <div class="overlay">
        <h3><?php echo $row['title']; ?></h3>
    </div>

</div>

<?php } ?>

</div>

<script src="script.js"></script>
</body>
</html>