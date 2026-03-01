<?php
include "../admin_header.php";
include "../db_connect.php";
include "news_helpers.php";

ensure_news_schema($conn);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0){
    header("Location: news_admin.php");
    exit();
}

$postResult = mysqli_query($conn, "SELECT * FROM news_posts WHERE id=$id LIMIT 1");
$post = $postResult ? mysqli_fetch_assoc($postResult) : null;
if(!$post){
    header("Location: news_admin.php?msg=" . urlencode("Post not found."));
    exit();
}

$mediaResult = mysqli_query($conn, "SELECT * FROM news_media WHERE post_id=$id ORDER BY sort_order ASC, id ASC");
?>

<h1>Edit News Post</h1>

<form method="POST" action="news_update.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo (int)$post['id']; ?>">

    <label>Headline</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

    <label>Category</label>
    <select name="category" required>
        <?php
        $categories = ['General','Politics','City','Crime','Business','Sports','Education','Health'];
        foreach($categories as $cat):
        ?>
            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo (($post['category'] ?? 'General') === $cat) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Author Name</label>
    <input type="text" name="author_name" value="<?php echo htmlspecialchars($post['author_name']); ?>" required>

    <label>Short Summary</label>
    <textarea name="summary" rows="3" required><?php echo htmlspecialchars((string)$post['summary']); ?></textarea>

    <label>Full Content</label>
    <textarea name="content" rows="12" required><?php echo htmlspecialchars($post['content']); ?></textarea>

    <label>Status</label>
    <select name="status">
        <option value="1" <?php echo ((int)$post['status'] === 1) ? 'selected' : ''; ?>>Published</option>
        <option value="0" <?php echo ((int)$post['status'] === 0) ? 'selected' : ''; ?>>Draft</option>
    </select>

    <h3>Existing Media</h3>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-bottom:14px;">
        <?php while($media = mysqli_fetch_assoc($mediaResult)): ?>
            <div style="background:#fff;border:1px solid #ddd;padding:10px;border-radius:8px;">
                <?php if($media['media_type'] === 'image'): ?>
                    <img src="uploads/<?php echo htmlspecialchars($media['file_name']); ?>" alt="Media" style="width:100%;height:130px;object-fit:cover;border-radius:6px;">
                <?php else: ?>
                    <video controls style="width:100%;height:130px;object-fit:cover;border-radius:6px;">
                        <source src="uploads/<?php echo htmlspecialchars($media['file_name']); ?>">
                    </video>
                <?php endif; ?>
                <label style="display:flex;gap:8px;align-items:center;margin-top:8px;">
                    <input type="checkbox" name="delete_media[]" value="<?php echo (int)$media['id']; ?>">
                    Remove this media
                </label>
            </div>
        <?php endwhile; ?>
    </div>

    <label>Add More Media</label>
    <input type="file" name="media[]" multiple accept="image/jpeg,image/png,image/webp,video/mp4,video/webm,video/ogg">

    <button type="submit">Update News</button>
</form>

<?php include "../admin_footer.php"; ?>
