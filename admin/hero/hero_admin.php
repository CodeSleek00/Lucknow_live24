<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['admin'])){
    header("Location: ../admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Hero Image Dashboard</title>
<link rel="stylesheet" href="../admin_style.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="sidebar">
    <h2>NEWS ADMIN</h2>
    <a href="../admin_dashboard.php">Dashboard</a>
    <a href="../add_breaking.php">Add Breaking</a>
    <a href="../manage_breaking.php">Manage Breaking</a>
    <a href="hero_admin.php">Manage Hero Images</a>
    <a href="../admin_logout.php">Logout</a>
</div>

<div class="main">
    <h1>Hero Image Dashboard</h1>

    <?php if(isset($_GET['msg'])): ?>
        <p class="notice <?php echo (isset($_GET['status']) && $_GET['status'] === 'success') ? 'notice-success' : 'notice-error'; ?>">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </p>
    <?php endif; ?>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required>
        <button type="submit">Upload Image</button>
    </form>

    <hr>

    <h2>All Images</h2>

    <div class="image-grid">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM hero_images ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($result)){
    ?>
    <div class="img-box">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Hero Image">
        <a href="delete.php?id=<?php echo (int)$row['id']; ?>" onclick="return confirm('Delete this image?')">Delete</a>
    </div>
    <?php } ?>
    </div>
</div>

</body>
</html>
