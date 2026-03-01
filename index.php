<?php
include 'admin/db_connect.php';
include 'admin/news/news_helpers.php';

ensure_news_schema($conn);

$news = [];
$q = mysqli_query($conn, "SELECT news_text FROM breaking_news WHERE status = 1 ORDER BY id DESC");
while($row = mysqli_fetch_assoc($q)){
    $news[] = $row['news_text'];
}

$heroImages = [];
$heroResult = mysqli_query($conn, "SELECT * FROM hero_images ORDER BY id DESC");
while($heroRow = mysqli_fetch_assoc($heroResult)){
    $heroImages[] = $heroRow;
}

$postRows = [];
$postResult = mysqli_query($conn, "
    SELECT
        p.*,
        (
            SELECT m.file_name
            FROM news_media m
            WHERE m.post_id = p.id
            ORDER BY m.sort_order ASC, m.id ASC
            LIMIT 1
        ) AS cover_media,
        (
            SELECT m.media_type
            FROM news_media m
            WHERE m.post_id = p.id
            ORDER BY m.sort_order ASC, m.id ASC
            LIMIT 1
        ) AS cover_type
    FROM news_posts p
    WHERE p.status = 1
    ORDER BY p.id DESC
    LIMIT 8
");
while($post = mysqli_fetch_assoc($postResult)){
    $postRows[] = $post;
}

function short_text(string $text, int $limit = 140): string {
    if(strlen($text) <= $limit){
        return $text;
    }
    return rtrim(substr($text, 0, $limit)) . '...';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lucknow Live24 | Breaking News</title>
<style>
:root{
    --brand:#ba1111;
    --brand-dark:#8f0909;
    --ink:#111720;
    --page:#eef1f5;
    --card:#ffffff;
    --muted:#5e6f7f;
}
*{box-sizing:border-box;}
body{margin:0;font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;background:var(--page);color:#16202a;}
a{text-decoration:none;color:inherit;}
.site-shell{max-width:1280px;margin:0 auto;background:#fff;min-height:100vh;}
.top-bar{display:flex;justify-content:space-between;align-items:center;padding:14px 20px;border-bottom:1px solid #e7ebef;background:#fff;}
.brand{font-weight:800;font-size:1.45rem;color:var(--brand);}
.date-pill{background:#f1f4f8;padding:6px 12px;border-radius:30px;color:#274154;font-size:.84rem;}
.breaking{display:flex;align-items:stretch;background:#101820;min-height:56px;overflow:hidden;border-bottom:3px solid var(--brand);}
.breaking-tag{display:flex;align-items:center;padding:0 16px;background:var(--brand);color:#fff;font-weight:700;letter-spacing:.7px;font-size:.84rem;}
.breaking-track{overflow:hidden;white-space:nowrap;flex:1;display:flex;align-items:center;}
.breaking-text{display:inline-block;padding-left:100%;color:#f2dede;animation:ticker 28s linear infinite;}
.breaking-text span{margin-right:26px;}
@keyframes ticker{0%{transform:translateX(0)}100%{transform:translateX(-100%)}}
.hero{position:relative;height:calc(100svh - 118px);min-height:540px;background:#101820;overflow:hidden;}
.hero-slide{position:absolute;inset:0;opacity:0;transition:opacity .8s ease;}
.hero-slide.active{opacity:1;}
.hero-slide img{width:100%;height:100%;object-fit:cover;display:block;}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,.22),rgba(0,0,0,.68));z-index:2;}
.hero-content{position:relative;z-index:3;height:100%;display:flex;flex-direction:column;justify-content:flex-end;gap:14px;padding:clamp(18px,4vw,44px);color:#fff;max-width:900px;}
.hero-kicker{display:inline-block;width:max-content;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.28);padding:7px 12px;border-radius:30px;font-size:.75rem;letter-spacing:1px;font-weight:700;text-transform:uppercase;}
.hero-title{margin:0;font-size:clamp(1.5rem,4.8vw,3.4rem);line-height:1.1;max-width:18ch;}
.hero-sub{margin:0;color:#dae4ee;max-width:62ch;line-height:1.55;font-size:clamp(.92rem,1.8vw,1.05rem);}
.hero-dots{position:absolute;right:20px;bottom:20px;display:flex;gap:8px;z-index:3;}
.hero-dot{width:12px;height:12px;border-radius:50%;border:1px solid rgba(255,255,255,.95);background:transparent;cursor:pointer;padding:0;}
.hero-dot.active{background:#fff;}
.page-section{padding:24px 20px 34px;}
.section-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;border-bottom:1px solid #dce2e9;padding-bottom:8px;}
.section-head h2{margin:0;font-size:1.35rem;color:#0f1d29;}
.badge{background:#ecf2f7;padding:5px 10px;border-radius:30px;font-size:.8rem;color:#2c4f66;}
.story-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(255px,1fr));gap:16px;}
.story{background:var(--card);border:1px solid #e4e8ed;border-radius:14px;overflow:hidden;box-shadow:0 8px 22px rgba(0,0,0,.05);transition:transform .2s ease,box-shadow .2s ease;}
.story:hover{transform:translateY(-3px);box-shadow:0 12px 24px rgba(0,0,0,.10);}
.story-media{height:180px;background:#0f1720;position:relative;}
.story-media img,.story-media video{width:100%;height:100%;object-fit:cover;display:block;}
.story-body{padding:13px;}
.story-title{margin:0 0 8px;font-size:1.06rem;line-height:1.35;color:#122132;}
.story-text{margin:0 0 11px;color:#536474;font-size:.92rem;line-height:1.5;}
.story-foot{display:flex;justify-content:space-between;align-items:center;gap:8px;font-size:.8rem;color:#6d7e8f;}
.read-btn{background:var(--brand);color:#fff;padding:6px 10px;border-radius:24px;font-weight:700;font-size:.76rem;}
.read-btn:hover{background:var(--brand-dark);}
.breaking-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px;}
.breaking-card{background:#fff;border:1px solid #e4e9ef;border-radius:12px;padding:12px;}
.breaking-card .tag{font-size:.72rem;font-weight:700;color:var(--brand);letter-spacing:.6px;text-transform:uppercase;margin-bottom:5px;}
.breaking-card p{margin:0;font-size:.94rem;line-height:1.45;}
.footer{background:#121922;color:#c6d3dd;text-align:center;padding:14px 20px;font-size:.85rem;}
.no-state{background:#f4f7fb;border:1px dashed #cbd6e0;border-radius:10px;padding:18px;color:#3b5367;}
@media (max-width:960px){.hero{height:72svh;min-height:440px;}}
@media (max-width:760px){.top-bar{flex-direction:column;align-items:flex-start;gap:6px;padding:12px 14px;}.page-section{padding:20px 14px 26px;}.hero{height:65svh;min-height:360px;}.breaking-tag{padding:0 10px;font-size:.75rem;}.breaking-text{font-size:.9rem;}.hero-dots{right:14px;bottom:14px;}}
</style>
</head>
<body>
<div class="site-shell">
    <header class="top-bar">
        <div class="brand">Lucknow Live24</div>
        <div class="date-pill"><?php echo date('l, d M Y'); ?></div>
    </header>

    <section class="breaking">
        <div class="breaking-tag">BREAKING</div>
        <div class="breaking-track">
            <div class="breaking-text">
                <?php if(count($news) > 0): ?>
                    <?php foreach($news as $line): ?>
                        <span>• <?php echo htmlspecialchars($line); ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span>• No active breaking news right now.</span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="hero">
        <?php if(count($heroImages) > 0): ?>
            <?php foreach($heroImages as $idx => $img): ?>
                <div class="hero-slide <?php echo $idx === 0 ? 'active' : ''; ?>">
                    <img src="admin/hero/uploads/<?php echo rawurlencode((string)$img['image']); ?>" alt="Hero visual <?php echo $idx + 1; ?>">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="hero-slide active" style="display:grid;place-items:center;background:#1a2430;color:#fff;font-size:1.1rem;">Upload hero images from admin panel.</div>
        <?php endif; ?>

        <div class="hero-overlay"></div>

        <div class="hero-content">
            <span class="hero-kicker">Live Coverage</span>
            <h1 class="hero-title"><?php echo isset($postRows[0]['title']) ? htmlspecialchars((string)$postRows[0]['title']) : 'City headlines, ground reports and verified local updates.'; ?></h1>
            <p class="hero-sub">Headlines pe click karo aur full detailed page open hoga jisme text ke beech image/video automatically place hoga.</p>
        </div>

        <?php if(count($heroImages) > 1): ?>
            <div class="hero-dots">
                <?php foreach($heroImages as $idx => $img): ?>
                    <button class="hero-dot <?php echo $idx === 0 ? 'active' : ''; ?>" data-slide="<?php echo $idx; ?>" aria-label="Slide <?php echo $idx + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <main class="page-section">
        <div class="section-head">
            <h2>Top News Stories</h2>
            <span class="badge"><?php echo count($postRows); ?> published</span>
        </div>

        <?php if(count($postRows) > 0): ?>
            <div class="story-grid">
                <?php foreach($postRows as $post): ?>
                    <article class="story">
                        <a href="news.php?slug=<?php echo urlencode((string)$post['slug']); ?>">
                            <div class="story-media">
                                <?php if(!empty($post['cover_media']) && $post['cover_type'] === 'video'): ?>
                                    <video muted playsinline preload="metadata">
                                        <source src="admin/news/uploads/<?php echo rawurlencode((string)$post['cover_media']); ?>">
                                    </video>
                                <?php elseif(!empty($post['cover_media'])): ?>
                                    <img src="admin/news/uploads/<?php echo rawurlencode((string)$post['cover_media']); ?>" alt="<?php echo htmlspecialchars((string)$post['title']); ?>">
                                <?php elseif(isset($heroImages[0]['image'])): ?>
                                    <img src="admin/hero/uploads/<?php echo rawurlencode((string)$heroImages[0]['image']); ?>" alt="News visual">
                                <?php else: ?>
                                    <div style="height:100%;display:grid;place-items:center;color:#cfd8e3;background:#1b2632;">No media</div>
                                <?php endif; ?>
                            </div>
                            <div class="story-body">
                                <h3 class="story-title"><?php echo htmlspecialchars((string)$post['title']); ?></h3>
                                <p class="story-text"><?php echo htmlspecialchars(short_text((string)$post['summary'], 140)); ?></p>
                                <div class="story-foot">
                                    <span>By <?php echo htmlspecialchars((string)$post['author_name']); ?></span>
                                    <span class="read-btn">Read Full</span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-state">Admin panel se pehla news post publish karein. Stories yahi show hongi.</div>
        <?php endif; ?>
    </main>

    <section class="page-section" style="padding-top:0;">
        <div class="section-head">
            <h2>Live Breaking Feed</h2>
            <span class="badge"><?php echo count($news); ?> alerts</span>
        </div>

        <div class="breaking-grid">
            <?php if(count($news) > 0): ?>
                <?php foreach(array_slice($news, 0, 8) as $line): ?>
                    <article class="breaking-card">
                        <div class="tag">Breaking</div>
                        <p><?php echo htmlspecialchars($line); ?></p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-state">No active breaking feed available right now.</div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">&copy; <?php echo date('Y'); ?> Lucknow Live24. All rights reserved.</footer>
</div>

<script>
const heroSlides = document.querySelectorAll('.hero-slide');
const heroDots = document.querySelectorAll('.hero-dot');
let current = 0;

function setHeroSlide(index){
    heroSlides.forEach((slide, i) => slide.classList.toggle('active', i === index));
    heroDots.forEach((dot, i) => dot.classList.toggle('active', i === index));
    current = index;
}

if(heroSlides.length > 1){
    setInterval(() => {
        setHeroSlide((current + 1) % heroSlides.length);
    }, 4200);
}

heroDots.forEach((dot) => {
    dot.addEventListener('click', () => {
        const idx = Number(dot.getAttribute('data-slide'));
        if(!Number.isNaN(idx)){
            setHeroSlide(idx);
        }
    });
});
</script>
</body>
</html>
