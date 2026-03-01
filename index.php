<?php
include 'partials/site_bootstrap.php';

$pageTitle = 'Lucknow Live24 | Home';
$activeNav = 'index.php';

$topPosts = fetch_posts($conn, 8, 'p.status=1');
$featuredTitle = isset($topPosts[0]['title']) ? $topPosts[0]['title'] : 'Trusted updates from Lucknow and across Uttar Pradesh.';

$categoryCounts = [];
$catResult = mysqli_query($conn, "SELECT category, COUNT(*) as total FROM news_posts WHERE status=1 GROUP BY category ORDER BY total DESC LIMIT 5");
if($catResult){
    while($row = mysqli_fetch_assoc($catResult)){
        $categoryCounts[] = $row;
    }
}

include 'partials/site_header.php';
?>

<div class="page">
    <section class="hero">
        <?php if(count($siteHeroImages) > 0): ?>
            <?php foreach($siteHeroImages as $idx => $image): ?>
                <div class="hero-slide <?php echo $idx === 0 ? 'active' : ''; ?>">
                    <img src="admin/hero/uploads/<?php echo rawurlencode($image); ?>" alt="Hero visual <?php echo $idx + 1; ?>">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="hero-slide active" style="display:grid;place-items:center;color:#d2dfec;">Add hero images from admin panel.</div>
        <?php endif; ?>

        <div class="hero-overlay"></div>

        <div class="hero-content">
            <span class="hero-kicker">Live Coverage</span>
            <h1><?php echo esc($featuredTitle); ?></h1>
            <p>Interactive newsroom with real-time headlines, category pages, article details, and multimedia stories.</p>
        </div>

        <?php if(count($siteHeroImages) > 1): ?>
            <div class="hero-dots">
                <?php foreach($siteHeroImages as $idx => $image): ?>
                    <button class="hero-dot <?php echo $idx === 0 ? 'active' : ''; ?>" data-slide="<?php echo $idx; ?>" aria-label="Slide <?php echo $idx + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section>
        <div class="section-head">
            <h2>Top News Stories</h2>
            <a href="latest.php" class="section-badge">View All</a>
        </div>

        <div class="grid">
            <?php if(count($topPosts) > 0): ?>
                <?php foreach($topPosts as $post): ?>
                    <article class="card">
                        <a href="news.php?slug=<?php echo urlencode($post['slug']); ?>">
                            <div class="card-media">
                                <?php if($post['cover_media'] && $post['cover_type'] === 'video'): ?>
                                    <video muted playsinline preload="metadata">
                                        <source src="admin/news/uploads/<?php echo rawurlencode($post['cover_media']); ?>">
                                    </video>
                                <?php else: ?>
                                    <?php $coverPath = get_cover_path($post['cover_media'], $post['cover_type'], $siteHeroImages); ?>
                                    <?php if($coverPath !== ''): ?>
                                        <img src="<?php echo esc($coverPath); ?>" alt="<?php echo esc($post['title']); ?>">
                                    <?php else: ?>
                                        <div style="height:100%;display:grid;place-items:center;color:#c5d4e4;">No media</div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="card-kicker"><?php echo esc($post['category']); ?></div>
                                <h3><?php echo esc($post['title']); ?></h3>
                                <p><?php echo esc(short_text((string)$post['summary'], 145)); ?></p>
                                <div class="card-foot">
                                    <span>By <?php echo esc($post['author_name']); ?></span>
                                    <span><?php echo date('d M', strtotime((string)$post['created_at'])); ?></span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card"><div class="card-body"><h3>No published stories</h3><p>Create posts from admin panel.</p></div></div>
            <?php endif; ?>
        </div>
    </section>

    <section>
        <div class="section-head">
            <h2>Explore Sections</h2>
            <span class="section-badge">Multi-Page Navigation</span>
        </div>

        <div class="promo-grid">
            <a href="latest.php" class="promo-box">
                <h3>Latest Desk</h3>
                <p>Chronological feed of all published stories with card + detail view.</p>
            </a>
            <a href="videos.php" class="promo-box">
                <h3>Video Bulletin</h3>
                <p>Dedicated listing for all story videos uploaded from admin panel.</p>
            </a>
            <a href="category.php" class="promo-box">
                <h3>Category Pages</h3>
                <p>Topic-wise news pages for politics, city, sports, business and more.</p>
            </a>
        </div>
    </section>

    <section>
        <div class="section-head">
            <h2>Live Category Trends</h2>
            <span class="section-badge">Auto Generated</span>
        </div>

        <div class="split-layout">
            <div class="list-stack">
                <?php if(count($categoryCounts) > 0): ?>
                    <?php foreach($categoryCounts as $cat): ?>
                        <a class="list-item" href="category.php?name=<?php echo urlencode((string)$cat['category']); ?>">
                            <strong><?php echo esc((string)$cat['category']); ?></strong>
                            <span><?php echo (int)$cat['total']; ?> published stories</span>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="list-item"><strong>No categories yet</strong><span>Categories will appear after publishing stories.</span></div>
                <?php endif; ?>
            </div>
            <div class="cta">
                <h3>Want Better Story Reach?</h3>
                <p>Use multiple media blocks in article editor. The system auto-inserts images and videos between paragraphs for richer storytelling.</p>
                <a href="admin/news/news_admin.php" class="btn" style="margin-top:8px;">Open Admin News Panel</a>
            </div>
        </div>
    </section>
</div>

<?php include 'partials/site_footer.php'; ?>
