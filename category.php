<?php
include 'partials/site_bootstrap.php';

$pageTitle = 'Categories | Lucknow Live24';
$activeNav = 'category.php';

$categories = [];
$catResult = mysqli_query($conn, "SELECT category, COUNT(*) as total FROM news_posts WHERE status=1 GROUP BY category ORDER BY category ASC");
if($catResult){
    while($row = mysqli_fetch_assoc($catResult)){
        $categories[] = $row;
    }
}

$selectedCategory = trim($_GET['name'] ?? '');
$selectedEsc = mysqli_real_escape_string($conn, $selectedCategory);
$where = "p.status=1";
if($selectedCategory !== ''){
    $where .= " AND p.category='$selectedEsc'";
}
$posts = fetch_posts($conn, 30, $where);

include 'partials/site_header.php';
?>
<div class="page">
    <div class="section-head">
        <h2>Categories</h2>
        <span class="section-badge"><?php echo $selectedCategory !== '' ? esc($selectedCategory) : 'All'; ?></span>
    </div>

    <div class="filter-bar" style="margin-bottom:14px;">
        <a class="filter-chip <?php echo $selectedCategory === '' ? 'active' : ''; ?>" href="category.php">All</a>
        <?php foreach($categories as $cat): ?>
            <a class="filter-chip <?php echo $selectedCategory === $cat['category'] ? 'active' : ''; ?>" href="category.php?name=<?php echo urlencode((string)$cat['category']); ?>"><?php echo esc((string)$cat['category']); ?> (<?php echo (int)$cat['total']; ?>)</a>
        <?php endforeach; ?>
    </div>

    <div class="grid">
        <?php if(count($posts) > 0): ?>
            <?php foreach($posts as $post): ?>
                <article class="card">
                    <a href="news.php?slug=<?php echo urlencode((string)$post['slug']); ?>">
                        <div class="card-media">
                            <?php $coverPath = get_cover_path($post['cover_media'], $post['cover_type'], $siteHeroImages); ?>
                            <?php if($coverPath): ?>
                                <img src="<?php echo esc($coverPath); ?>" alt="<?php echo esc((string)$post['title']); ?>">
                            <?php else: ?>
                                <div style="height:100%;display:grid;place-items:center;color:#c5d4e4;">No media</div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="card-kicker"><?php echo esc((string)$post['category']); ?></div>
                            <h3><?php echo esc((string)$post['title']); ?></h3>
                            <p><?php echo esc(short_text((string)$post['summary'], 150)); ?></p>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card"><div class="card-body"><h3>No stories found</h3><p>Try another category filter.</p></div></div>
        <?php endif; ?>
    </div>
</div>
<?php include 'partials/site_footer.php'; ?>
