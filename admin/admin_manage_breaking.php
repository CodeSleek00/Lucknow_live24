<?php
include 'db_connect.php';
$result = mysqli_query($conn, "SELECT * FROM breaking_news ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Breaking News</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Manage Breaking News</h2>

<table>
<tr>
    <th>ID</th>
    <th>News</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['news_text'] ?></td>
    <td><?= $row['status'] ? 'LIVE' : 'OFF' ?></td>
    <td>
        <a href="toggle_breaking.php?id=<?= $row['id'] ?>">
            <?= $row['status'] ? 'Disable' : 'Enable' ?>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>
