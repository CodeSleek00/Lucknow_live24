<?php include 'admin_header.php'; ?>
<?php include 'db_connect.php'; ?>

<table>
<tr>
    <th>ID</th>
    <th>News</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$q = mysqli_query($conn, "SELECT * FROM breaking_news ORDER BY id DESC");
while($row = mysqli_fetch_assoc($q)){
?>
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

<?php include 'admin_footer.php'; ?>
