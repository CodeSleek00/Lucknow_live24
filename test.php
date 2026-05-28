<?php
include 'database_connection/db.php';

$query = "SELECT * FROM reels ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reels</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="reels-container">

<?php
if(mysqli_num_rows($result) == 0){
    echo "<h2 style='color:white;text-align:center;margin-top:50vh;'>No reels uploaded yet</h2>";
}

while($row = mysqli_fetch_assoc($result)) {
?>

<div class="reel">

    <video class="video" src="<?php echo htmlspecialchars($row['video']); ?>" muted loop></video>

    <div class="overlay">
        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
    </div>

</div>

<?php } ?>

</div>

<script src="script.js"></script>
</body>
</html>