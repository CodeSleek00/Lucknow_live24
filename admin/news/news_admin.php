<?php
include "../admin_header.php";
include "../db_connect.php";
include "news_helpers.php";

ensure_news_schema($conn);

$result = mysqli_query($conn, "
    SELECT p.*, COUNT(m.id) AS media_count
    FROM news_posts p
    LEFT JOIN news_media m ON m.post_id = p.id
    GROUP BY p.id
    ORDER BY p.id DESC
");
?>

<h1>Manage News</h1>
<p><a href="news_add.php">+ Add New News Post</a></p>

<?php if(isset($_GET['msg'])): ?>
    <p style="padding:10px;border:1px solid #ddd;background:#fff;"><?php echo htmlspecialchars($_GET['msg']); ?></p>
<?php endif; ?>

<table>
<tr>
    <th>ID</th>
    <th>Headline</th>
    <th>Author</th>
    <th>Media</th>
    <th>Status</th>
    <th>Created</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?php echo (int)$row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['title']); ?></td>
    <td><?php echo htmlspecialchars($row['author_name']); ?></td>
    <td><?php echo (int)$row['media_count']; ?></td>
    <td><?php echo ((int)$row['status'] === 1) ? 'Published' : 'Draft'; ?></td>
    <td><?php echo htmlspecialchars((string)$row['created_at']); ?></td>
    <td>
        <a href="news_edit.php?id=<?php echo (int)$row['id']; ?>">Edit</a> |
        <a href="news_toggle.php?id=<?php echo (int)$row['id']; ?>">Toggle</a> |
        <a href="news_delete.php?id=<?php echo (int)$row['id']; ?>" onclick="return confirm('Delete this post and all media?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<?php include "../admin_footer.php"; ?>
