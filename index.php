<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lucknow Live24 — classy, professional news layout</title>
  <!-- calm, professional font system -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f4f7fc;
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      color: #1e2b37;
      line-height: 1.5;
    }

    .site-wrapper {
      max-width: 1440px;
      margin: 2rem auto;
      background: white;
      border-radius: 32px 32px 24px 24px;
      box-shadow: 0 20px 40px -10px rgba(0, 20, 30, 0.15);
      overflow: hidden;
    }

    /* refined header */
    .top-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2.5rem;
      border-bottom: 1px solid #e9edf2;
      background: white;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .brand-icon {
      background: #ba1111;
      width: 8px;
      height: 32px;
      border-radius: 20px;
    }
    .brand-text {
      font-weight: 700;
      font-size: 1.65rem;
      letter-spacing: -0.02em;
      color: #101820;
      font-family: 'Playfair Display', serif;
    }
    .brand-text span {
      color: #ba1111;
      font-weight: 600;
    }

    .date-pill {
      background: #f0f4fa;
      padding: 0.5rem 1.2rem;
      border-radius: 40px;
      font-size: 0.9rem;
      font-weight: 500;
      color: #2c3f55;
      border: 1px solid #dbe2ec;
    }

    /* breaking ticker refined */
    .breaking-ribbon {
      display: flex;
      align-items: center;
      background: #0c1724;
      border-radius: 0;
      margin: 0 0 0px 0;
    }

    .breaking-label {
      background: #ba1111;
      color: white;
      font-weight: 600;
      font-size: 0.85rem;
      padding: 0.7rem 1.6rem;
      letter-spacing: 0.5px;
      border-radius: 0 40px 40px 0;
      line-height: 1;
      box-shadow: 4px 0 10px rgba(0,0,0,0.2);
      text-transform: uppercase;
    }

    .breaking-marquee {
      flex: 1;
      overflow: hidden;
      padding: 0 1.2rem;
    }

    .marquee-track {
      display: inline-block;
      white-space: nowrap;
      padding-left: 100%;
      color: #e6edf5;
      font-weight: 450;
      font-size: 1rem;
      animation: scrollNews 32s linear infinite;
    }

    .marquee-track span {
      margin-right: 2.5rem;
    }
    .marquee-track span::before {
      content: "●";
      color: #ba1111;
      margin-right: 8px;
      font-size: 0.7rem;
      vertical-align: middle;
    }

    @keyframes scrollNews {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }

    /* hero – elegant overlay & typography */
    .hero-section {
      position: relative;
      height: 580px;
      max-height: 70vh;
      background: #0c1a24;
      overflow: hidden;
    }

    .hero-slides-container {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .hero-slide {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      opacity: 0;
      transition: opacity 0.9s cubic-bezier(0.23, 1, 0.32, 1);
      background-size: cover;
      background-position: center 30%;
    }
    .hero-slide.active {
      opacity: 1;
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0,10,18,0.85) 10%, rgba(0,25,45,0.45) 50%, rgba(0,10,20,0.3) 90%);
      z-index: 2;
    }

    .hero-content {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      z-index: 5;
      padding: 3rem 4rem;
      max-width: 900px;
      color: white;
    }

    .hero-kicker {
      display: inline-block;
      background: rgba(186,17,17,0.92);
      padding: 0.4rem 1.2rem;
      border-radius: 30px;
      font-weight: 600;
      font-size: 0.8rem;
      letter-spacing: 0.4px;
      margin-bottom: 1.2rem;
      backdrop-filter: blur(4px);
      border: 1px solid rgba(255,255,255,0.2);
    }

    .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 5vw, 3.8rem);
      font-weight: 600;
      line-height: 1.1;
      margin-bottom: 1rem;
      text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .hero-description {
      font-size: 1.1rem;
      color: rgba(255,255,255,0.8);
      font-weight: 400;
      max-width: 600px;
      margin-bottom: 0.5rem;
    }

    .hero-dots {
      position: absolute;
      right: 3rem;
      bottom: 2.5rem;
      display: flex;
      gap: 0.8rem;
      z-index: 6;
    }

    .dot {
      width: 10px;
      height: 10px;
      border-radius: 20px;
      background: rgba(255,255,255,0.5);
      border: none;
      padding: 0;
      cursor: pointer;
      transition: all 0.2s;
    }
    .dot.active {
      background: white;
      width: 24px;
    }

    /* page sections – clean, spacious */
    .section {
      padding: 2.5rem 2.5rem 2rem;
    }

    .section-header {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      margin-bottom: 1.8rem;
      border-bottom: 2px solid #eef2f6;
      padding-bottom: 0.6rem;
    }

    .section-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.9rem;
      font-weight: 600;
      color: #0f202b;
      letter-spacing: -0.01em;
    }

    .section-badge {
      background: #e6edf6;
      padding: 0.3rem 1.2rem;
      border-radius: 50px;
      color: #2b4d6a;
      font-weight: 500;
      font-size: 0.9rem;
      border: 1px solid #cbdae7;
    }

    /* card grids – refined spacing, subtle depth */
    .story-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
    }

    .story-card {
      background: white;
      border-radius: 22px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0,20,30,0.04);
      transition: all 0.3s ease;
      border: 1px solid #ecf1f7;
      display: flex;
      flex-direction: column;
    }

    .story-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 30px -6px rgba(30, 60, 80, 0.12);
      border-color: #cddae9;
    }

    .card-media {
      height: 190px;
      background-color: #1f2d3a;
      position: relative;
    }

    .card-media img, .card-media video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .card-body {
      padding: 1.4rem 1.3rem 1.3rem;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .card-title {
      font-weight: 700;
      font-size: 1.2rem;
      line-height: 1.4;
      margin-bottom: 0.5rem;
      color: #11212e;
      font-family: 'Playfair Display', serif;
    }

    .card-summary {
      color: #4b6279;
      font-size: 0.92rem;
      margin-bottom: 1.3rem;
      line-height: 1.5;
      flex: 1;
    }

    .card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px dashed #d8e2ed;
      padding-top: 0.9rem;
      margin-top: auto;
    }

    .author {
      font-weight: 500;
      color: #436684;
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .author::before {
      content: "✎";
      font-size: 0.9rem;
      opacity: 0.8;
    }

    .read-link {
      background: #ba1111;
      color: white;
      padding: 0.35rem 1rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.8rem;
      letter-spacing: 0.3px;
      transition: background 0.2s;
    }
    .read-link:hover {
      background: #8f0909;
    }

    /* breaking card (smaller) */
    .breaking-feed-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.2rem;
    }

    .breaking-mini-card {
      background: #ffffff;
      border: 1px solid #e3eaf2;
      border-radius: 18px;
      padding: 1.2rem 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .breaking-mini-card .mini-tag {
      color: #ba1111;
      font-weight: 700;
      font-size: 0.7rem;
      text-transform: uppercase;
      margin-bottom: 0.5rem;
      letter-spacing: 0.8px;
    }
    .breaking-mini-card p {
      font-size: 0.95rem;
      font-weight: 500;
      color: #192f40;
      line-height: 1.4;
    }

    .empty-state {
      background: #f6faff;
      border: 1px dashed #b7c9dd;
      border-radius: 40px;
      padding: 2rem;
      text-align: center;
      color: #436077;
      font-weight: 450;
    }

    /* footer – minimal */
    .site-footer {
      background: #101a24;
      color: #b6cbd9;
      text-align: center;
      padding: 1.3rem 2.5rem;
      font-size: 0.9rem;
      border-top: 1px solid #263645;
    }

    /* responsive adjustments */
    @media (max-width: 800px) {
      .top-header { padding: 1rem 1.5rem; }
      .hero-content { padding: 2rem 1.5rem; }
      .section { padding: 1.8rem 1.5rem; }
      .hero-dots { right: 1.5rem; bottom: 1.5rem; }
      .brand-text { font-size: 1.4rem; }
    }

    @media (max-width: 600px) {
      .site-wrapper { margin: 0; border-radius: 0; }
      .breaking-label { padding: 0.5rem 1rem; font-size: 0.75rem; }
      .hero-title { font-size: 1.8rem; }
    }
  </style>
</head>
<body>
<div class="site-wrapper">

  <!-- header refined -->
  <header class="top-header">
    <div class="brand">
      <div class="brand-icon"></div>
      <div class="brand-text">Lucknow <span>Live24</span></div>
    </div>
    <div class="date-pill"><?php echo date('l, d M Y'); ?></div>
  </header>

  <!-- breaking ribbon (dynamic) -->
  <?php
  // simulate dynamic data (same as original backend logic)
  include 'admin/db_connect.php';
  include 'admin/news/news_helpers.php';
  ensure_news_schema($conn);
  $news = [];
  $q = mysqli_query($conn, "SELECT news_text FROM breaking_news WHERE status = 1 ORDER BY id DESC");
  while($row = mysqli_fetch_assoc($q)){ $news[] = $row['news_text']; }
  $heroImages = [];
  $heroResult = mysqli_query($conn, "SELECT * FROM hero_images ORDER BY id DESC");
  while($heroRow = mysqli_fetch_assoc($heroResult)){ $heroImages[] = $heroRow; }
  $postRows = [];
  $postResult = mysqli_query($conn, "
    SELECT p.*,
      (SELECT m.file_name FROM news_media m WHERE m.post_id = p.id ORDER BY m.sort_order ASC, m.id ASC LIMIT 1) AS cover_media,
      (SELECT m.media_type FROM news_media m WHERE m.post_id = p.id ORDER BY m.sort_order ASC, m.id ASC LIMIT 1) AS cover_type
    FROM news_posts p
    WHERE p.status = 1
    ORDER BY p.id DESC
    LIMIT 8
  ");
  while($post = mysqli_fetch_assoc($postResult)){ $postRows[] = $post; }
  function short_text(string $text, int $limit = 140): string {
    if(strlen($text) <= $limit) return $text;
    return rtrim(substr($text, 0, $limit)) . '…';
  }
  ?>

  <div class="breaking-ribbon">
    <span class="breaking-label">⚡ LIVE</span>
    <div class="breaking-marquee">
      <div class="marquee-track">
        <?php if(count($news) > 0): ?>
          <?php foreach($news as $line): ?>
            <span><?php echo htmlspecialchars($line); ?></span>
          <?php endforeach; ?>
        <?php else: ?>
          <span>No breaking news at the moment — stay tuned</span>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- hero area with dynamic images -->
  <section class="hero-section">
    <div class="hero-slides-container">
      <?php if(count($heroImages) > 0): ?>
        <?php foreach($heroImages as $idx => $img): ?>
          <div class="hero-slide <?php echo $idx === 0 ? 'active' : ''; ?>" 
               style="background-image: url('admin/hero/uploads/<?php echo rawurlencode((string)$img['image']); ?>');">
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="hero-slide active" style="background: #142a3c; display: flex; align-items: flex-end; justify-content: center; color: white; font-size: 1.4rem; padding: 3rem;">
          <span>📸 Upload hero images in admin</span>
        </div>
      <?php endif; ?>
    </div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
      <span class="hero-kicker">EXCLUSIVE GROUND REPORTS</span>
      <h1 class="hero-title"><?php 
        echo isset($postRows[0]['title']) 
          ? htmlspecialchars((string)$postRows[0]['title']) 
          : 'City headlines & verified local updates'; 
      ?></h1>
      <p class="hero-description">Click any story to read in full — embedded media, clean layout and authentic reporting.</p>
    </div>

    <?php if(count($heroImages) > 1): ?>
    <div class="hero-dots">
      <?php foreach($heroImages as $idx => $img): ?>
        <button class="dot <?php echo $idx === 0 ? 'active' : ''; ?>" data-slide="<?php echo $idx; ?>" aria-label="slide <?php echo $idx+1; ?>"></button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </section>

  <!-- main stories grid -->
  <div class="section">
    <div class="section-header">
      <h2>Top stories</h2>
      <span class="section-badge"><?php echo count($postRows); ?> articles</span>
    </div>

    <?php if(count($postRows) > 0): ?>
    <div class="story-grid">
      <?php foreach($postRows as $post): ?>
      <article class="story-card">
        <a href="news.php?slug=<?php echo urlencode((string)$post['slug']); ?>" style="text-decoration:none;color:inherit;display:contents;">
          <div class="card-media">
            <?php if(!empty($post['cover_media']) && $post['cover_type'] === 'video'): ?>
              <video muted playsinline preload="metadata" src="admin/news/uploads/<?php echo rawurlencode((string)$post['cover_media']); ?>"></video>
            <?php elseif(!empty($post['cover_media'])): ?>
              <img src="admin/news/uploads/<?php echo rawurlencode((string)$post['cover_media']); ?>" alt="<?php echo htmlspecialchars((string)$post['title']); ?>">
            <?php elseif(isset($heroImages[0]['image'])): ?>
              <img src="admin/hero/uploads/<?php echo rawurlencode((string)$heroImages[0]['image']); ?>" alt="news">
            <?php else: ?>
              <div style="height:100%; background:#1d3443; display:flex; align-items:center; justify-content:center; color:#a5bfd3;">📷</div>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <h3 class="card-title"><?php echo htmlspecialchars((string)$post['title']); ?></h3>
            <p class="card-summary"><?php echo htmlspecialchars(short_text((string)$post['summary'], 130)); ?></p>
            <div class="card-footer">
              <span class="author"><?php echo htmlspecialchars((string)$post['author_name']); ?></span>
              <span class="read-link">Read full</span>
            </div>
          </div>
        </a>
      </article>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
      <div class="empty-state">📰 Publish your first news post from admin panel – stories will appear here.</div>
    <?php endif; ?>
  </div>

  <!-- live breaking feed (compact) -->
  <div class="section" style="padding-top:0;">
    <div class="section-header">
      <h2>Breaking alerts</h2>
      <span class="section-badge"><?php echo count($news); ?> active</span>
    </div>

    <div class="breaking-feed-grid">
      <?php if(count($news) > 0): ?>
        <?php foreach(array_slice($news, 0, 8) as $line): ?>
        <div class="breaking-mini-card">
          <div class="mini-tag">🔔 just now</div>
          <p><?php echo htmlspecialchars($line); ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-state">⏸️ No breaking alerts at this moment.</div>
      <?php endif; ?>
    </div>
  </div>

  <!-- footer -->
  <footer class="site-footer">
    <span>© <?php echo date('Y'); ?> Lucknow Live24 — independent, verified, local. All rights reserved.</span>
  </footer>
</div>

<!-- simple dot navigation & autoplay -->
<script>
  (function() {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.dot');
    if (!slides.length) return;

    let currentIdx = 0;
    const total = slides.length;

    function showSlide(index) {
      if (index < 0) index = total - 1;
      if (index >= total) index = 0;
      slides.forEach((s, i) => s.classList.toggle('active', i === index));
      dots.forEach((d, i) => d.classList.toggle('active', i === index));
      currentIdx = index;
    }

    if (dots.length) {
      dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
          showSlide(i);
        });
      });
    }

    if (total > 1) {
      setInterval(() => {
        showSlide(currentIdx + 1);
      }, 4800);
    }
  })();
</script>
</body>
</html>