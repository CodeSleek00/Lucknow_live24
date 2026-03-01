<?php
include 'partials/site_bootstrap.php';

$slug = trim($_GET['slug'] ?? '');
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
    if($mediaResult){
        while($m = mysqli_fetch_assoc($mediaResult)){
            $mediaRows[] = $m;
        }
    }

    $relatedResult = mysqli_query($conn, "
        SELECT id, title, slug, category, created_at
        FROM news_posts
        WHERE status=1 AND id != $postId
        ORDER BY id DESC
        LIMIT 6
    ");
    if($relatedResult){
        while($r = mysqli_fetch_assoc($relatedResult)){
            $relatedRows[] = $r;
        }
    }
}

$pageTitle = $post ? ($post['title'] . ' | Lucknow Live24') : 'Story Not Found | Lucknow Live24';
$activeNav = 'latest.php';
include 'partials/site_header.php';
?>

<?php if(!$post): ?>
    <div class="page">
        <div class="article-panel">
            <h2>News Not Found</h2>
            <p>The story is unavailable or unpublished.</p>
            <a href="latest.php" class="btn">Back to Latest</a>
        </div>
    </div>
<?php else: ?>
    <div class="article-wrap">
        <article class="article-panel">
            <div class="card-kicker"><?php echo esc((string)$post['category']); ?></div>
            <h1 class="article-title"><?php echo esc((string)$post['title']); ?></h1>
            <div class="article-meta">By <?php echo esc((string)$post['author_name']); ?> • <?php echo date('d M Y, h:i A', strtotime((string)$post['created_at'])); ?></div>
            <div class="article-summary"><?php echo nl2br(esc((string)$post['summary'])); ?></div>

            <div class="article-content">
                <?php echo render_news_content_with_media((string)$post['content'], $mediaRows); ?>
            </div>
        </article>

        <aside class="article-panel">
            <div class="section-head" style="margin-top:0;">
                <h2 style="font-size:1.2rem;">Related Stories</h2>
            </div>
            <div class="list-stack">
                <?php if(count($relatedRows) > 0): ?>
                    <?php foreach($relatedRows as $row): ?>
                        <a class="list-item" href="news.php?slug=<?php echo urlencode((string)$row['slug']); ?>">
                            <strong><?php echo esc((string)$row['title']); ?></strong>
                            <span><?php echo esc((string)$row['category']); ?> • <?php echo date('d M Y', strtotime((string)$row['created_at'])); ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="list-item"><strong>No related stories.</strong></div>
                <?php endif; ?>
            </div>
        </aside>
    </div>
<?php endif; ?>

<?php include 'partials/site_footer.php'; ?>
