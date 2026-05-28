<?php
include '../database_connection/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    /* =========================
       MAIN IMAGE (SINGLE IMAGE)
    ========================== */
    $imageName = "";

    if(!empty($_FILES['image']['name'])){
        $tmp = $_FILES['image']['tmp_name'];
        $imageName = time() . "_img_" . $_FILES['image']['name'];

        move_uploaded_file($tmp, "uploads/images/" . $imageName);
    }

    /* =========================
       MULTIPLE IMAGES (GALLERY)
    ========================== */
    $galleryFiles = [];

    if(!empty($_FILES['images']['name'][0])){
        foreach($_FILES['images']['name'] as $key => $img){
            $tmp = $_FILES['images']['tmp_name'][$key];
            $newName = time() . "_g_" . rand(1000,9999) . "_" . $img;

            move_uploaded_file($tmp, "uploads/images/" . $newName);
            $galleryFiles[] = $newName;
        }
    }

    /* =========================
       MULTIPLE VIDEOS
    ========================== */
    $videoFiles = [];

    if(!empty($_FILES['videos']['name'][0])){
        foreach($_FILES['videos']['name'] as $key => $vid){
            $tmp = $_FILES['videos']['tmp_name'][$key];
            $newName = time() . "_v_" . rand(1000,9999) . "_" . $vid;

            move_uploaded_file($tmp, "uploads/videos/" . $newName);
            $videoFiles[] = $newName;
        }
    }

    $galleryJson = json_encode($galleryFiles);
    $videosJson = json_encode($videoFiles);

    /* =========================
       INSERT QUERY
    ========================== */
    $query = "INSERT INTO news
    (title, slug, description, image, images, videos)
    VALUES
    ('$title','$slug','$description','$imageName','$galleryJson','$videosJson')";

    mysqli_query($conn, $query);

    header("Location: add_news.php?success=1");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add News</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f4f4f4;
    padding:40px;
}

.container{
    max-width:750px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

h1{
    margin-bottom:25px;
}

input, textarea{
    width:100%;
    padding:14px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:16px;
}

button{
    background:#e60023;
    color:white;
    border:none;
    padding:14px 25px;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
}

button:hover{
    background:#c4001d;
}

.success{
    background:#d4edda;
    color:#155724;
    padding:12px;
    margin-bottom:20px;
    border-radius:8px;
}

label{
    font-weight:bold;
    display:block;
    margin:10px 0 6px;
}
</style>
</head>
<body>

<div class="container">

<?php if(isset($_GET['success'])){ ?>
<div class="success">News Added Successfully</div>
<?php } ?>

<h1>Add News</h1>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="title" placeholder="News Title" required>

<textarea name="description" rows="6" placeholder="News Description"></textarea>

<!-- SINGLE IMAGE -->
<label>Main Image</label>
<input type="file" name="image" accept="image/*" required>

<!-- GALLERY -->
<label>Gallery Images (Multiple)</label>
<input type="file" name="images[]" multiple accept="image/*">

<!-- VIDEOS -->
<label>Videos (Multiple)</label>
<input type="file" name="videos[]" multiple accept="video/*">

<button type="submit" name="submit">Publish News</button>

</form>

</div>

</body>
</html>