<?php include 'admin_header.php'; ?>
<?php include 'db_connect.php'; ?>

<?php
if(isset($_POST['add'])){
    $news = mysqli_real_escape_string($conn, $_POST['news']);
    mysqli_query($conn, "INSERT INTO breaking_news (news_text) VALUES ('$news')");
}
?>

<h2>Add Breaking News</h2>

<form method="POST">
    <input type="text" name="news" placeholder="Enter Breaking News" required>
    <button name="add">Add</button>
</form>

<?php include 'admin_footer.php'; ?>
