<?php
include 'partials/site_bootstrap.php';

$pageTitle = 'Video Bulletin | Lucknow Live24';
$activeNav = 'videos.php';

$videoPosts = [];
$result = mysqli_query($conn, "
    SELECT DISTINCT p.*,
      (
        SELECT m.file_name FROM news_media m
        WHERE m.post_id = p.id AND m.media_type='video'
        ORDER BY m.sort_order ASC, m.id ASC LIMIT 1
      ) AS first_video
    FROM news_posts p
    INNER JOIN news_media vm ON vm.post_id = p.id AND vm.media_type='video'
    WHERE p.status=1
    ORDER BY p.id DESC
    LIMIT 40
");
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $videoPosts[] = $row;
    }
}

include 'partials/site_header.php';
?>
<div class="page">
    <div class="section-head">
        <h2>Video Bulletin</h2>
        <span class="section-badge"><?php echo count($videoPosts); ?> video stories</span>
    </div>

    <div class="grid">
        <?php if(count($videoPosts) > 0): ?>
            <?php foreach($videoPosts as $post): ?>
                <article class="card">
                    <a href="news.php?slug=<?php echo urlencode($post['slug']); ?>">
                        <div class="card-media">
                            <video controls preload="metadata">
                                <source src="admin/news/uploads/<?php echo rawurlencode((string)$post['first_video']); ?>">
                            </video>
                        </div>
                        <div class="card-body">
                            <div class="card-kicker"><?php echo esc((string)$post['category']); ?></div>
                            <h3><?php echo esc((string)$post['title']); ?></h3>
                            <p><?php echo esc(short_text((string)$post['summary'], 140)); ?></p>
                            <div class="card-foot"><span><?php echo esc((string)$post['author_name']); ?></span><span>Play Story</span></div>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card"><div class="card-body"><h3>No video stories</h3><p>Add video files in a news post from admin panel.</p></div></div>
        <?php endif; ?>
    </div>
</div>
<?php include 'partials/site_footer.php'; ?>
