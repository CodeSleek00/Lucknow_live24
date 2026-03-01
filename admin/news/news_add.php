<?php
include "../admin_header.php";
include "../db_connect.php";
include "news_helpers.php";

ensure_news_schema($conn);
?>

<h1>Add News Post</h1>

<form method="POST" action="news_save.php" enctype="multipart/form-data">
    <label>Headline</label>
    <input type="text" name="title" placeholder="Enter headline" required>

    <label>Author Name</label>
    <input type="text" name="author_name" placeholder="Reporter name" required>

    <label>Short Summary</label>
    <textarea name="summary" rows="3" placeholder="1-2 line summary" required></textarea>

    <label>Full Content</label>
    <textarea name="content" rows="12" placeholder="Write full article. New paragraph ke liye blank line use karein." required></textarea>

    <label>Upload Images / Videos (Multiple)</label>
    <input type="file" name="media[]" multiple accept="image/jpeg,image/png,image/webp,video/mp4,video/webm,video/ogg">

    <label>Publish Now?</label>
    <select name="status">
        <option value="1">Published</option>
        <option value="0">Draft</option>
    </select>

    <button type="submit">Save News</button>
</form>

<p style="font-size:13px;color:#555;">Tip: system paragraph ke baad auto image/video place karega upload order ke hisab se.</p>

<?php include "../admin_footer.php"; ?>
