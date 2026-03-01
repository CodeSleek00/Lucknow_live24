<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="admin_style.css">
</head>
<body>

<h1>Hero Image Dashboard</h1>

<form action="upload.php" method="POST" enctype="multipart/form-data">
<input type="file" name="image" required>
<button type="submit">Upload Image</button>
</form>

<hr>

<h2>All Images</h2>

<div class="image-grid">
<?php
$result=mysqli_query($conn,"SELECT * FROM hero_images ORDER BY id DESC");
while($row=mysqli_fetch_assoc($result)){
?>
<div class="img-box">
<img src="../uploads/<?php echo $row['image']; ?>">
<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
</div>
<?php } ?>
</div>

<br>
<a href="logout.php">Logout</a>

</body>
</html>