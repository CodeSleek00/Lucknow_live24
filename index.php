<?php
include 'admin/db_connect.php';

/* Fetch active breaking news */
$q = mysqli_query($conn, "
    SELECT news_text
    FROM breaking_news
    WHERE status = 1
    ORDER BY id DESC
");

$news = [];
while($row = mysqli_fetch_assoc($q)){
    $news[] = $row['news_text'];
}

$heroImages = [];
$heroResult = mysqli_query($conn, "SELECT * FROM hero_images ORDER BY id DESC");
while($heroRow = mysqli_fetch_assoc($heroResult)){
    $heroImages[] = $heroRow;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lucknow Live24 | Breaking News</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{
    --brand-red:#c40000;
    --brand-red-dark:#8f0000;
    --ink:#141414;
    --text:#f8f8f8;
    --muted:#dedede;
    --card:#fff;
    --page:#f1f3f5;
}

*{
    box-sizing:border-box;
}

body{
    margin:0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background:var(--page);
    color:#111;
}

a{
    color:inherit;
    text-decoration:none;
}

.site-top{
    background:linear-gradient(90deg, var(--ink), #262626 50%, #1b1b1b);
    color:var(--text);
    padding:14px clamp(14px, 3vw, 42px);
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
}

.brand{
    font-size:clamp(1.1rem, 2.2vw, 1.45rem);
    font-weight:800;
    letter-spacing:.4px;
}

.top-date{
    color:#cfcfcf;
    font-size:.92rem;
}

.breaking-wrapper{
    width:100%;
    min-height:68px;
    background:var(--brand-red);
    display:flex;
    align-items:center;
    overflow:hidden;
}

.breaking-label{
    background:#000;
    color:#fff;
    padding:0 22px;
    min-height:68px;
    display:flex;
    align-items:center;
    font-size:1.05rem;
    font-weight:700;
    letter-spacing:.8px;
    white-space:nowrap;
}

.breaking-marquee{
    overflow:hidden;
    white-space:nowrap;
    width:100%;
}

.breaking-text{
    display:inline-block;
    padding-left:100%;
    color:#fff;
    font-size:1rem;
    animation:scrollNews 24s linear infinite;
}

.breaking-text span{
    margin:0 18px;
}

@keyframes scrollNews{
    0% { transform:translateX(0); }
    100% { transform:translateX(-100%); }
}

.hero{
    position:relative;
    height:calc(100svh - 132px);
    min-height:520px;
    overflow:hidden;
    isolation:isolate;
    background:#111;
}

.hero-slider,
.slide{
    position:absolute;
    inset:0;
}

.slide{
    opacity:0;
    transition:opacity .9s ease;
}

.slide.active{
    opacity:1;
}

.slide img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.hero-fallback{
    position:absolute;
    inset:0;
    display:grid;
    place-items:center;
    color:#fff;
    background:radial-gradient(circle at 20% 20%, #2e2e2e, #111 65%);
    font-size:1.1rem;
}

.hero-overlay{
    position:absolute;
    inset:0;
    background:
        linear-gradient(180deg, rgba(0,0,0,.36) 0%, rgba(0,0,0,.62) 100%),
        linear-gradient(120deg, rgba(196,0,0,.30) 0%, rgba(0,0,0,0) 45%);
    z-index:1;
}

.hero-content{
    position:relative;
    z-index:2;
    max-width:1100px;
    margin:0 auto;
    height:100%;
    padding:clamp(24px, 4vw, 50px);
    display:flex;
    flex-direction:column;
    justify-content:flex-end;
    gap:16px;
    color:#fff;
}

.hero-kicker{
    display:inline-flex;
    align-items:center;
    gap:10px;
    font-size:.85rem;
    letter-spacing:1.3px;
    font-weight:700;
    text-transform:uppercase;
    width:max-content;
    padding:8px 12px;
    border-radius:999px;
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.22);
}

.hero-title{
    margin:0;
    font-size:clamp(1.6rem, 5vw, 3.2rem);
    line-height:1.12;
    max-width:17ch;
}

.hero-sub{
    margin:0;
    max-width:60ch;
    color:var(--muted);
    font-size:clamp(.95rem, 2vw, 1.08rem);
    line-height:1.55;
}

.hero-tags{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    padding:0;
    margin:0;
    list-style:none;
}

.hero-tags li{
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.22);
    padding:8px 12px;
    border-radius:999px;
    font-size:.86rem;
}

.hero-dots{
    position:absolute;
    z-index:2;
    right:clamp(14px, 2vw, 28px);
    bottom:clamp(18px, 2.4vw, 30px);
    display:flex;
    gap:8px;
}

.hero-dot{
    width:11px;
    height:11px;
    border-radius:50%;
    border:1px solid rgba(255,255,255,.85);
    background:transparent;
    cursor:pointer;
    padding:0;
}

.hero-dot.active{
    background:#fff;
}

.content{
    max-width:1180px;
    margin:28px auto 0;
    padding:0 clamp(14px, 3vw, 40px) 36px;
}

.section-title{
    margin:0 0 14px;
    font-size:clamp(1.2rem, 3.1vw, 1.8rem);
    color:#121212;
}

.news-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(230px, 1fr));
    gap:14px;
}

.news-card{
    background:var(--card);
    border:1px solid #e3e3e3;
    border-radius:12px;
    padding:16px;
    box-shadow:0 8px 20px rgba(0,0,0,.05);
}

.news-card p{
    margin:0;
    line-height:1.5;
}

.news-meta{
    margin-bottom:9px;
    color:var(--brand-red);
    font-size:.82rem;
    letter-spacing:.7px;
    text-transform:uppercase;
    font-weight:700;
}

.footer{
    background:#141414;
    color:#dadada;
    text-align:center;
    padding:14px;
    font-size:.9rem;
}

@media (max-width:980px){
    .hero{
        height:70svh;
        min-height:420px;
    }
}

@media (max-width:768px){
    .site-top{
        flex-direction:column;
        align-items:flex-start;
        gap:3px;
    }

    .breaking-wrapper{
        min-height:58px;
    }

    .breaking-label{
        min-height:58px;
        padding:0 12px;
        font-size:.86rem;
    }

    .breaking-text{
        font-size:.9rem;
    }

    .hero{
        height:64svh;
        min-height:360px;
    }

    .hero-content{
        gap:12px;
    }

    .hero-tags li{
        font-size:.8rem;
    }
}

@media (max-width:500px){
    .hero{
        height:58svh;
        min-height:320px;
    }

    .hero-sub{
        font-size:.92rem;
    }

    .hero-dots{
        right:14px;
        bottom:16px;
    }
}
</style>
</head>
<body>

<header class="site-top">
    <div class="brand">Lucknow Live24</div>
    <div class="top-date"><?php echo date('l, d M Y'); ?></div>
</header>

<div class="breaking-wrapper">
    <div class="breaking-label">BREAKING</div>

    <div class="breaking-marquee">
        <div class="breaking-text">
            <?php
            if(count($news) > 0){
                foreach($news as $n){
                    echo "<span>• " . htmlspecialchars($n) . "</span>";
                }
            } else {
                echo "<span>No Breaking News Available</span>";
            }
            ?>
        </div>
    </div>
</div>

<section class="hero">
    <div class="hero-slider">
        <?php if(count($heroImages) > 0): ?>
            <?php foreach($heroImages as $index => $img): ?>
                <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img src="admin/hero/uploads/<?php echo htmlspecialchars($img['image']); ?>" alt="Hero News Visual <?php echo $index + 1; ?>">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="hero-fallback">No Hero Image Uploaded Yet</div>
        <?php endif; ?>
    </div>

    <div class="hero-overlay"></div>

  

    <?php if(count($heroImages) > 1): ?>
        <div class="hero-dots" aria-label="Hero slider controls">
            <?php foreach($heroImages as $dotIndex => $img): ?>
                <button class="hero-dot <?php echo $dotIndex === 0 ? 'active' : ''; ?>" type="button" data-slide="<?php echo $dotIndex; ?>" aria-label="Go to slide <?php echo $dotIndex + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<main class="content">
    <h2 class="section-title">Latest Updates</h2>

    <div class="news-grid">
        <?php if(count($news) > 0): ?>
            <?php foreach(array_slice($news, 0, 8) as $newsItem): ?>
                <article class="news-card">
                    <div class="news-meta">Breaking Update</div>
                    <p><?php echo htmlspecialchars($newsItem); ?></p>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <article class="news-card">
                <div class="news-meta">Status</div>
                <p>Abhi tak koi active update publish nahi hua hai.</p>
            </article>
        <?php endif; ?>
    </div>
</main>

<footer class="footer">&copy; <?php echo date('Y'); ?> Lucknow Live24. All rights reserved.</footer>

<script>
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.hero-dot');
let currentSlide = 0;

const setSlide = (index) => {
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });

    currentSlide = index;
};

if (slides.length > 1) {
    setInterval(() => {
        const next = (currentSlide + 1) % slides.length;
        setSlide(next);
    }, 4000);
}

if (dots.length) {
    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const target = Number(dot.getAttribute('data-slide'));
            if (!Number.isNaN(target)) {
                setSlide(target);
            }
        });
    });
}
</script>

</body>
</html>
