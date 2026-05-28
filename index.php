<?php
include 'database_connection/db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$query = "SELECT * FROM news ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>News Section</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f3f3f3;
}

.news-wrapper{
    width:95%;
    max-width:1400px;
    margin:40px auto;
}

.news-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
}

.news-card{
    background:white;
    border-radius:14px;
    overflow:hidden;
    text-decoration:none;
    color:black;
    transition:0.3s;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.news-card:hover{
    transform:translateY(-5px);
}

.news-image{
    width:100%;
    height:240px;
    object-fit:cover;
}

.news-content{
    padding:15px;
}

.news-title{
    font-size:24px;
    font-weight:bold;
    line-height:1.4;
}

.big-card{
    grid-column:span 2;
}

.big-card .news-image{
    height:390px;
}

.big-card .news-title{
    font-size:34px;
}

@media(max-width:992px){

    .news-grid{
        grid-template-columns:1fr 1fr;
    }

    .big-card{
        grid-column:span 2;
    }
}

@media(max-width:768px){

    .news-grid{
        display:flex;
        overflow-x:auto;
        gap:15px;
        padding-bottom:10px;
        scroll-snap-type:x mandatory;
    }

    .news-grid::-webkit-scrollbar{
        height:5px;
    }

    .news-grid::-webkit-scrollbar-thumb{
        background:#ccc;
        border-radius:20px;
    }

    .news-card{
        min-width:300px;
        flex-shrink:0;
        scroll-snap-align:start;
    }

    .big-card{
        min-width:340px;
    }

    .big-card .news-image{
        height:250px;
    }

    .news-title{
        font-size:18px;
    }

    .big-card .news-title{
        font-size:22px;
    }
}

</style>
</head>
<body>

<div class="news-wrapper">

<div class="news-grid">

<?php
$count = 0;

while($row = mysqli_fetch_assoc($result)){

$count++;

$class = ($count > 3) ? 'big-card' : '';

?>

<a href="news.php?slug=<?php echo $row['slug']; ?>" class="news-card <?php echo $class; ?>">

<img src="admin/uploads/<?php echo $row['image']; ?>" class="news-image">

<div class="news-content">

<h2 class="news-title">
<?php echo $row['title']; ?>
</h2>

</div>

</a>

<?php } ?>

</div>

</div>

</body>
</html>