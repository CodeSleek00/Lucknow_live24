<?php
include 'database_connection/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['submit'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    $imageName = $_FILES['image']['name'];
    $tmpName   = $_FILES['image']['tmp_name'];

    $newName = time() . "_" . $imageName;

    move_uploaded_file($tmpName, "uploads/" . $newName);

    $query = "INSERT INTO news(title, slug, description, image)
              VALUES('$title','$slug','$description','$newName')";

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

input,
textarea{
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

<input type="file" name="image" required>

<button type="submit" name="submit">Publish News</button>

</form>

</div>

</body>
</html>