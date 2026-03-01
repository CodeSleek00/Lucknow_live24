<?php
include 'admin/db_connect.php';
include 'admin/news/news_helpers.php';

ensure_news_schema($conn);

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$slugEscaped = mysqli_real_escape_string($conn, $slug);

$postResult = mysqli_query($conn, "SELECT * FROM news_posts WHERE slug='$slugEscaped' AND status=1 LIMIT 1");
$post = $postResult ? mysqli_fetch_assoc($postResult) : null;

if(!$post){
    http_response_code(404);
}

$mediaRows = [];
$relatedRows = [];

if($post){
    $postId = (int)$post['id'];
    $mediaResult = mysqli_query($conn, "SELECT * FROM news_media WHERE post_id=$postId ORDER BY sort_order ASC, id ASC");
    while($m = mysqli_fetch_assoc($mediaResult)){
        $mediaRows[] = $m;
    }

    $relatedResult = mysqli_query($conn, "
        SELECT id, title, slug, created_at
        FROM news_posts
        WHERE status=1 AND id != $postId
        ORDER BY id DESC
        LIMIT 4
    ");

    while($r = mysqli_fetch_assoc($relatedResult)){
        $relatedRows[] = $r;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $post ? htmlspecialchars($post['title']) : 'News Not Found'; ?> | Lucknow Live24</title>
<style>
body{margin:0;font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;background:#f4f5f7;color:#171717;}
a{text-decoration:none;color:inherit;}
.top{background:#141414;color:#fff;padding:12px 16px;display:flex;justify-content:space-between;gap:10px;align-items:center;}
.top a{color:#fff;font-weight:600;}
.wrap{max-width:1100px;margin:20px auto;padding:0 14px 40px;display:grid;grid-template-columns:2fr 1fr;gap:18px;}
.article{background:#fff;border-radius:12px;border:1px solid #e8e8e8;padding:18px;}
.kicker{display:inline-block;background:#c40000;color:#fff;padding:6px 10px;border-radius:999px;font-size:.78rem;font-weight:700;letter-spacing:.7px;text-transform:uppercase;}
h1{margin:12px 0 8px;font-size:clamp(1.5rem,3.4vw,2.4rem);line-height:1.15;}
.meta{color:#666;font-size:.92rem;margin-bottom:14px;}
.summary{font-size:1.06rem;line-height:1.6;background:#fafafa;border-left:3px solid #c40000;padding:10px 12px;border-radius:6px;margin-bottom:16px;}
.content p{line-height:1.78;margin:0 0 14px;}
.news-media{margin:18px 0;background:#fafafa;border:1px solid #ebebeb;border-radius:10px;padding:8px;}
.news-media img,.news-media video{width:100%;max-height:520px;object-fit:cover;border-radius:8px;display:block;background:#000;}
.sidebar{display:flex;flex-direction:column;gap:14px;}
.panel{background:#fff;border:1px solid #e8e8e8;border-radius:12px;padding:14px;}
.panel h3{margin:0 0 12px;font-size:1.05rem;}
.related{display:flex;flex-direction:column;gap:10px;}
.related a{padding:10px;background:#f7f7f7;border-radius:8px;display:block;}
.related a:hover{background:#ededed;}
.small{font-size:.84rem;color:#666;display:block;margin-top:4px;}
.not-found{max-width:760px;margin:48px auto;padding:0 14px;}
@media (max-width:900px){.wrap{grid-template-columns:1fr;}.sidebar{order:2;}}
</style>
</head>
<body>
<div class="top">
    <a href="index.php">← Back to Home</a>
    <div><?php echo date('d M Y'); ?></div>
</div>

<?php if(!$post): ?>
    <div class="not-found">
        <h2>News not found</h2>
        <p>Requested article available nahi hai ya publish nahi hua.</p>
    </div>
<?php else: ?>
    <div class="wrap">
        <article class="article">
            <span class="kicker">News Report</span>
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <div class="meta">By <?php echo htmlspecialchars($post['author_name']); ?> • <?php echo date('d M Y, h:i A', strtotime((string)$post['created_at'])); ?></div>
            <div class="summary"><?php echo nl2br(htmlspecialchars((string)$post['summary'])); ?></div>

            <div class="content">
                <?php echo render_news_content_with_media((string)$post['content'], $mediaRows); ?>
            </div>
        </article>

        <aside class="sidebar">
            <div class="panel">
                <h3>Related News</h3>
                <div class="related">
                    <?php if(count($relatedRows) === 0): ?>
                        <p>No related news yet.</p>
                    <?php else: ?>
                        <?php foreach($relatedRows as $row): ?>
                            <a href="news.php?slug=<?php echo urlencode($row['slug']); ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                                <span class="small"><?php echo date('d M Y', strtotime((string)$row['created_at'])); ?></span>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
<?php endif; ?>

</body>
</html>
