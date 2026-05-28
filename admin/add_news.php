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
       MULTIPLE IMAGES UPLOAD
    ========================== */
    $imageFiles = [];
    if(!empty($_FILES['images']['name'][0])){

        foreach($_FILES['images']['name'] as $key => $imageName){

            $tmpName = $_FILES['images']['tmp_name'][$key];
            $newName = time() . "_" . rand(1000,9999) . "_" . $imageName;

            move_uploaded_file($tmpName, "uploads/images/" . $newName);

            $imageFiles[] = $newName;
        }
    }

    /* =========================
       MULTIPLE VIDEOS UPLOAD
    ========================== */
    $videoFiles = [];
    if(!empty($_FILES['videos']['name'][0])){

        foreach($_FILES['videos']['name'] as $key => $videoName){

            $tmpName = $_FILES['videos']['tmp_name'][$key];
            $newName = time() . "_" . rand(1000,9999) . "_" . $videoName;

            move_uploaded_file($tmpName, "uploads/videos/" . $newName);

            $videoFiles[] = $newName;
        }
    }

    // Convert to JSON for DB storage
    $imagesJson = json_encode($imageFiles);
    $videosJson = json_encode($videoFiles);

    /* =========================
       INSERT QUERY
    ========================== */
    $query = "INSERT INTO news(title, slug, description, images, videos)
              VALUES('$title','$slug','$description','$imagesJson','$videosJson')";

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
    max-width:700px;
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
    margin-bottom:20px;
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
    margin-bottom:6px;
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

<label>Upload Multiple Images</label>
<input type="file" name="images[]" multiple accept="image/*">

<label>Upload Multiple Videos</label>
<input type="file" name="videos[]" multiple accept="video/*">

<button type="submit" name="submit">Publish News</button>

</form>

</div>

</body>
</html>