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
       PARAGRAPHS (NEW FEATURE)
    ========================== */
    $paragraphs = isset($_POST['paragraphs']) ? $_POST['paragraphs'] : [];
    $paragraphs = array_filter($paragraphs); // remove empty
    $paragraphsJson = json_encode(array_values($paragraphs));

    /* =========================
       MAIN IMAGE
    ========================== */
    $imageName = "";

    if(!empty($_FILES['image']['name'])){
        $tmp = $_FILES['image']['tmp_name'];
        $imageName = time() . "_img_" . $_FILES['image']['name'];

        move_uploaded_file($tmp, "uploads/images/" . $imageName);
    }

    /* =========================
       GALLERY IMAGES
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
       VIDEOS
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
       INSERT QUERY (UPDATED)
    ========================== */
    $query = "INSERT INTO news
    (title, slug, description, paragraphs, image, images, videos)
    VALUES
    ('$title','$slug','$description','$paragraphsJson','$imageName','$galleryJson','$videosJson')";

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
    max-width:800px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

input, textarea{
    width:100%;
    padding:14px;
    margin-bottom:12px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:16px;
}

button{
    background:#e60023;
    color:#fff;
    border:none;
    padding:12px 18px;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#c4001d;
}

.add-btn{
    background:#333;
    margin-bottom:15px;
}

.paragraph-box{
    position:relative;
    margin-bottom:10px;
}

.remove-btn{
    position:absolute;
    right:10px;
    top:10px;
    background:red;
    color:#fff;
    border:none;
    border-radius:5px;
    padding:5px 8px;
    cursor:pointer;
}

.success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
}
</style>
</head>
<body>

<div class="container">

<?php if(isset($_GET['success'])){ ?>
<div class="success">News Added Successfully</div>
<?php } ?>

<h2>Add News</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="title" placeholder="News Title" required>
<textarea name="description" rows="4" placeholder="Short Description"></textarea>

<hr style="margin:15px 0;">

<h3>Paragraphs</h3>

<div id="paragraph-wrapper">

    <div class="paragraph-box">
        <textarea name="paragraphs[]" rows="4" placeholder="Paragraph 1"></textarea>
    </div>

</div>

<button type="button" class="add-btn" onclick="addParagraph()">+ Add Paragraph</button>

<hr>

<label>Main Image</label>
<input type="file" name="image" accept="image/*" required>

<label>Gallery Images</label>
<input type="file" name="images[]" multiple accept="image/*">

<label>Videos</label>
<input type="file" name="videos[]" multiple accept="video/*">

<br><br>
<button type="submit" name="submit">Publish News</button>

</form>

</div>

<script>
let count = 1;

function addParagraph(){
    count++;

    const div = document.createElement("div");
    div.classList.add("paragraph-box");

    div.innerHTML = `
        <textarea name="paragraphs[]" rows="4" placeholder="Paragraph ${count}"></textarea>
        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">X</button>
    `;

    document.getElementById("paragraph-wrapper").appendChild(div);
}
</script>

</body>
</html>