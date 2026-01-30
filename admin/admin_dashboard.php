<?php include 'admin_header.php'; ?>
<?php include 'db_connect.php'; ?>

<?php
$count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM breaking_news")
);
?>

<h1>Dashboard</h1>

<div class="card">
    <h3>Total Breaking News</h3>
    <p><?= $count['total'] ?></p>
</div>

<?php include 'admin_footer.php'; ?>
