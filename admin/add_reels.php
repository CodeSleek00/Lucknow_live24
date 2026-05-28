<?php
include '../database_connection/db.php';

if(isset($_POST['upload'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $video_name = $_FILES['video']['name'];
    $tmp_name = $_FILES['video']['tmp_name'];

    $ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));
    $allowed = ['mp4','webm','ogg'];

    if(!in_array($ext, $allowed)){
        die("Only video files allowed");
    }

    // 🔥 ABSOLUTE PATH FIX (MAIN FIX)
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/videos/";

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $newName = time() . "_" . rand(1000,9999) . "." . $ext;

    $fullPath = $upload_dir . $newName;   // server path
    $dbPath = "uploads/videos/" . $newName; // store in DB

    if(move_uploaded_file($tmp_name, $fullPath)) {

        $query = "INSERT INTO reels (title, video) VALUES ('$title', '$dbPath')";
        mysqli_query($conn, $query);

        echo "<script>alert('Reel uploaded successfully');</script>";

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