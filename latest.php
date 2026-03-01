<?php
include 'partials/site_bootstrap.php';

$pageTitle = 'Latest News | Lucknow Live24';
$activeNav = 'latest.php';

$posts = fetch_posts($conn, 60, 'p.status=1');

include 'partials/site_header.php';
?>
<div class="page">
    <div class="section-head">
        <h2>Latest News Feed</h2>
        <span class="section-badge"><?php echo count($posts); ?> stories</span>
    </div>

    <div class="grid">
        <?php if(count($posts) > 0): ?>
            <?php foreach($posts as $post): ?>
                <article class="card">
                    <a href="news.php?slug=<?php echo urlencode($post['slug']); ?>">
                        <div class="card-media">
                            <?php if($post['cover_media'] && $post['cover_type'] === 'video'): ?>
                                <video muted playsinline preload="metadata"><source src="admin/news/uploads/<?php echo rawurlencode($post['cover_media']); ?>"></video>
                            <?php else: ?>
                                <?php $coverPath = get_cover_path($post['cover_media'], $post['cover_type'], $siteHeroImages); ?>
                                <?php if($coverPath): ?>
                                    <img src="<?php echo esc($coverPath); ?>" alt="<?php echo esc($post['title']); ?>">
                                <?php else: ?>
                                    <div style="height:100%;display:grid;place-items:center;color:#c5d4e4;">No media</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="card-kicker"><?php echo esc($post['category']); ?></div>
                            <h3><?php echo esc($post['title']); ?></h3>
                            <p><?php echo esc(short_text((string)$post['summary'], 160)); ?></p>
                            <div class="card-foot">
                                <span><?php echo esc($post['author_name']); ?></span>
                                <span><?php echo date('d M Y', strtotime((string)$post['created_at'])); ?></span>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card"><div class="card-body"><h3>No posts yet</h3><p>Publish posts from admin panel.</p></div></div>
        <?php endif; ?>
    </div>
</div>
<?php include 'partials/site_footer.php'; ?>
