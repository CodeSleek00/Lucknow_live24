<!DOCTYPE html>
<html>
<head>
    <title>Add Breaking News</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Add Breaking News</h2>

<form action="save_breaking.php" method="POST">
    <input type="text" name="news_text" placeholder="Enter breaking news..." required>
    <button type="submit">ADD</button>
</form>

<a href="admin_manage_breaking.php">Manage News</a>

</body>
</html>
