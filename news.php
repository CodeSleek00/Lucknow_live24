<?php
include 'database_connection/db.php';

$slug = $_GET['slug'];

$query = "SELECT * FROM news WHERE slug='$slug'";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo $data['title']; ?></title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f5f5f5;
}

.container{
    width:90%;
    max-width:1000px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
}

img{
    width:100%;
    border-radius:12px;
    margin-bottom:20px;
}

h1{
    font-size:42px;
    margin-bottom:20px;
}

p{
    font-size:20px;
    line-height:1.8;
    color:#333;
}

.date{
    color:gray;
    margin-bottom:20px;
}

@media(max-width:768px){

    h1{
        font-size:28px;
    }

    p{
        font-size:17px;
    }
}

</style>
</head>
<body>

<div class="container">

<img src="uploads/<?php echo $data['image']; ?>">

<h1><?php echo $data['title']; ?></h1>

<div class="date">
Published:
<?php echo date("d M Y", strtotime($data['created_at'])); ?>
</div>

<p>
<?php echo nl2br($data['description']); ?>
</p>

</div>

</body>
</html>