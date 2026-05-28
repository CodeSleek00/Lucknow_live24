<?php
include '../database_connection/db.php';

if(isset($_POST['upload'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $video_name = $_FILES['video']['name'];
    $tmp_name = $_FILES['video']['tmp_name'];

    // Create folder if not exists
    if (!is_dir("uploads/videos")) {
        mkdir("uploads/videos", 0777, true);
    }

    // File extension check
    $ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));
    $allowed = ['mp4', 'webm', 'ogg'];

    if (!in_array($ext, $allowed)) {
        echo "<script>alert('Only video files allowed');</script>";
        exit;
    }

    // Unique file name
    $newName = time() . "_" . rand(1000,9999) . "." . $ext;
    $folder = "uploads/videos/" . $newName;

    if(move_uploaded_file($tmp_name, $folder)) {

        $query = "INSERT INTO reels (title, video) VALUES ('$title', '$folder')";

        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Reel uploaded successfully');</script>";
        } else {
            echo "<script>alert('Database error');</script>";
        }

    } else {
        echo "<script>alert('Upload failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Reel</title>
<style>
body{
    font-family: Arial;
    background:#111;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.form-box{
    background:#1c1c1c;
    padding:25px;
    border-radius:12px;
    width:300px;
}
input,button{
    width:100%;
    padding:10px;
    margin-top:10px;
}
button{
    background:red;
    border:none;
    color:white;
    font-weight:bold;
    cursor:pointer;
}
</style>
</head>
<body>

<div class="form-box">
<h2>Upload Reel</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Reel Title" required>
    <input type="file" name="video" accept="video/*" required>
    <button type="submit" name="upload">Upload</button>
</form>

</div>

</body>
</html>