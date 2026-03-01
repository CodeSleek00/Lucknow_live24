<?php include 'admin_header.php'; ?>
<?php include 'db_connect.php'; ?>
<?php include 'news/news_helpers.php'; ?>

<?php ensure_news_schema($conn); ?>

<?php
$count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM breaking_news")
);

$postCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM news_posts")
);
?>

<h1>Dashboard</h1>

<div class="card">
    <h3>Total Breaking News</h3>
    <p><?= $count['total'] ?></p>
</div>

<div class="card" style="margin-top:12px;">
    <h3>Total News Posts</h3>
    <p><?= $postCount['total'] ?></p>
</div>

<?php include 'admin_footer.php'; ?>
