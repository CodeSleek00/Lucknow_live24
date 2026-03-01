<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lucknow Live24 – natural news format</title>
  <style>
    /* ————————————————————————— */
    /* modern newspaper inspired */
    /* ————————————————————————— */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #f4f5f7;
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
      color: #1e1e1e;
      line-height: 1.5;
    }

    /* fallback font stack (no external) */
    h1, h2, h3, .brand, .nav-links, .breaking-label, .meta-tag {
      font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
    }

    /* subtle container */
    .page {
      max-width: 1300px;
      margin: 0 auto;
      background-color: white;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
    }

    /* ——— header / top bar ——— */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.85rem 2rem;
      background: #ffffff;
      border-bottom: 1px solid #e8eef2;
    }

    .brand {
      font-size: 1.7rem;
      font-weight: 700;
      letter-spacing: -0.3px;
      color: #B11A1A;
      line-height: 1.2;
    }
    .brand span {
      font-weight: 400;
      font-size: 1rem;
      color: #4b5b68;
      margin-left: 8px;
      letter-spacing: 0.2px;
    }

    .header-date {
      background: #f0f4f8;
      padding: 0.4rem 1.2rem;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 500;
      color: #1e3b4f;
    }

    /* ——— breaking news ——— */
    .breaking-strip {
      background-color: #1e262c;
      border-bottom: 3px solid #B11A1A;
      display: flex;
      flex-wrap: wrap;
      align-items: stretch;
    }

    .breaking-label {
      background: #B11A1A;
      color: white;
      font-weight: 700;
      font-size: 0.9rem;
      letter-spacing: 0.6px;
      padding: 0 1.5rem;
      display: flex;
      align-items: center;
      text-transform: uppercase;
      white-space: nowrap;
    }

    .breaking-ticker {
      flex: 1;
      overflow: hidden;
      background: #1e262c;
      padding: 0.6rem 0;
    }

    .ticker-content {
      display: inline-block;
      white-space: nowrap;
      padding-left: 100%;
      color: #f3dcdc;
      font-size: 0.98rem;
      font-weight: 400;
      animation: tickerSlide 30s linear infinite;
    }

    .ticker-content span {
      display: inline-block;
      margin-right: 28px;
      position: relative;
    }
    .ticker-content span::before {
      content: "●";
      color: #ff7b7b;
      font-size: 10px;
      margin-right: 10px;
      vertical-align: middle;
    }

    @keyframes tickerSlide {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }

    /* ——— hero section — smaller, natural card ——— */
    .hero-section {
      padding: 2rem 2rem 1.5rem 2rem;
      background: white;
    }

    .hero-container {
      display: grid;
      grid-template-columns: 1.2fr 0.9fr;
      gap: 1.8rem;
      background: #f9fbfd;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 12px 28px -8px rgba(0, 20, 30, 0.15);
      border: 1px solid #e9ecf0;
    }

    /* left: carousel with overlay text */
    .hero-visual {
      position: relative;
      min-height: 340px;
      background: #1f2a33;
      overflow: hidden;
    }

    .slider-container {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .slide-img {
      position: absolute;
      inset: 0;
      opacity: 0;
      transition: opacity 0.7s ease-in-out;
      background-color: #17222b;
    }

    .slide-img.active {
      opacity: 1;
      z-index: 2;
    }

    .slide-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .hero-caption {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 10;
      background: linear-gradient(0deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.3) 70%, transparent);
      color: white;
      padding: 2rem 1.8rem 1.5rem 1.8rem;
    }

    .caption-tag {
      background: #B11A1A;
      display: inline-block;
      padding: 0.2rem 1rem;
      border-radius: 30px;
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.4px;
      text-transform: uppercase;
      margin-bottom: 0.6rem;
      border: 1px solid rgba(255,255,255,0.2);
    }

    .caption-title {
      font-size: 1.6rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 0.3rem;
      max-width: 80%;
    }

    .caption-meta {
      display: flex;
      gap: 1rem;
      font-size: 0.8rem;
      color: #e0e0e0;
    }

    /* dots */
    .hero-dots {
      position: absolute;
      bottom: 1.2rem;
      right: 1.8rem;
      z-index: 20;
      display: flex;
      gap: 0.45rem;
    }

    .hero-dot {
      width: 30px;
      height: 4px;
      border-radius: 2px;
      background: rgba(255,255,255,0.5);
      border: none;
      cursor: pointer;
      padding: 0;
      transition: 0.2s;
    }

    .hero-dot.active {
      background: #ffffff;
      width: 40px;
    }

    /* right: text summary + headlines */
    .hero-summary {
      padding: 1.8rem 1.8rem 1.8rem 0.2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .summary-kicker {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #B11A1A;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .summary-headline {
      font-size: 1.7rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 0.75rem;
      color: #101214;
    }

    .summary-text {
      color: #2e404f;
      font-size: 0.95rem;
      margin-bottom: 1.4rem;
      max-width: 95%;
    }

    .mini-headlines {
      list-style: none;
      border-top: 1px solid #dde3e9;
      padding-top: 1rem;
    }

    .mini-headlines li {
      display: flex;
      gap: 0.8rem;
      align-items: center;
      padding: 0.55rem 0;
      border-bottom: 1px dashed #e2e9f0;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .mini-headlines li span {
      color: #B11A1A;
      font-weight: 700;
      font-size: 0.8rem;
      min-width: 42px;
    }

    .mini-headlines li a {
      color: #1d2b36;
      text-decoration: none;
      transition: color 0.1s;
    }
    .mini-headlines li a:hover {
      color: #B11A1A;
      text-decoration: underline;
    }

    /* ——— main content ——— */
    .content-area {
      padding: 0.5rem 2rem 3rem 2rem;
    }

    .section-header {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      border-bottom: 2px solid #cfd9e2;
      padding-bottom: 0.3rem;
      margin-bottom: 1.5rem;
    }

    .section-header h2 {
      font-size: 1.4rem;
      font-weight: 700;
      color: #0b1a26;
      letter-spacing: -0.2px;
    }

    .section-header .badge {
      background: #e1e9f2;
      padding: 0.2rem 0.9rem;
      border-radius: 40px;
      font-size: 0.8rem;
      color: #2e4958;
    }

    .news-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 1.5rem;
    }

    .news-card {
      background: white;
      border: 1px solid #e9edf2;
      border-radius: 18px;
      padding: 1.2rem 1.2rem 1.5rem 1.2rem;
      transition: box-shadow 0.2s;
      box-shadow: 0 5px 12px rgba(0,0,0,0.02);
    }

    .news-card:hover {
      box-shadow: 0 12px 22px -6px rgba(26, 48, 64, 0.12);
      border-color: #cbd5e1;
    }

    .card-category {
      font-size: 0.68rem;
      text-transform: uppercase;
      font-weight: 700;
      letter-spacing: 0.5px;
      color: #B11A1A;
      margin-bottom: 0.5rem;
    }

    .news-card p {
      font-size: 0.95rem;
      color: #1b2a36;
      line-height: 1.5;
    }

    .time-indicator {
      margin-top: 0.8rem;
      font-size: 0.7rem;
      color: #708797;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* fallback */
    .no-news {
      text-align: center;
      padding: 2rem;
      background: #f5f8fc;
      border-radius: 28px;
      color: #4a5c6b;
    }

    .footer {
      background: #1e262c;
      color: #b6c8d5;
      padding: 1.4rem 2rem;
      text-align: center;
      font-size: 0.85rem;
      border-top: 1px solid #313e48;
    }

    /* responsive */
    @media (max-width: 950px) {
      .hero-container {
        grid-template-columns: 1fr;
      }
      .hero-summary {
        padding: 1.8rem;
      }
      .caption-title {
        max-width: 100%;
      }
    }

    @media (max-width: 680px) {
      .top-bar {
        flex-direction: column;
        align-items: start;
        gap: 0.4rem;
        padding: 1rem;
      }
      .hero-section, .content-area {
        padding-left: 1rem;
        padding-right: 1rem;
      }
      .hero-dots {
        bottom: 0.8rem;
        right: 1rem;
      }
      .caption-title {
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
<div class="page">

  <!-- header -->
  <div class="top-bar">
    <div class="brand">Lucknow Live24 <span>हिंदी समाचार</span></div>
    <div class="header-date"><?php echo date('l, d M Y'); ?> · लखनऊ संस्करण</div>
  </div>

  <!-- breaking strip (natural but bold) -->
  <div class="breaking-strip">
    <div class="breaking-label">BREAKING</div>
    <div class="breaking-ticker">
      <div class="ticker-content">
        <?php
        include 'admin/db_connect.php';
        // fetch active news (same as original)
        $q = mysqli_query($conn, "SELECT news_text FROM breaking_news WHERE status = 1 ORDER BY id DESC");
        $news = [];
        while($row = mysqli_fetch_assoc($q)){ $news[] = $row['news_text']; }
        $heroImages = [];
        $heroResult = mysqli_query($conn, "SELECT * FROM hero_images ORDER BY id DESC");
        while($heroRow = mysqli_fetch_assoc($heroResult)){ $heroImages[] = $heroRow; }

        if(count($news) > 0){
          foreach($news as $n){
            echo "<span>" . htmlspecialchars($n) . "</span>";
          }
        } else {
          echo "<span>कोई ब्रेकिंग न्यूज़ नहीं · सामान्य प्रसारण जारी</span>";
        }
        ?>
      </div>
    </div>
  </div>

  <!-- HERO section – smaller, natural card (not fullscreen) -->
  <section class="hero-section">
    <div class="hero-container">
      <!-- left slider / visual part -->
      <div class="hero-visual">
        <div class="slider-container">
          <?php if(count($heroImages) > 0): ?>
            <?php foreach($heroImages as $idx => $img): ?>
              <div class="slide-img <?php echo $idx === 0 ? 'active' : ''; ?>" data-slide="<?php echo $idx; ?>">
                <img src="admin/hero/uploads/<?php echo htmlspecialchars($img['image']); ?>" alt="hero visual">
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div style="position:absolute; inset:0; background:#23303b; display:flex; align-items:center; justify-content:center; color:#ccc;">कोई हीरो छवि नहीं</div>
          <?php endif; ?>

          <!-- static caption overlay (can be dynamic later, but for design we show first slide info) -->
          <div class="hero-caption">
            <span class="caption-tag">टॉप स्टोरी</span>
            <h1 class="caption-title">
              <?php 
                $firstHeadline = $news[0] ?? 'लखनऊ की बड़ी खबरें, सीधा आपके सामने';
                echo htmlspecialchars(substr($firstHeadline, 0, 60)) . (strlen($firstHeadline)>60?'…':'');
              ?>
            </h1>
            <div class="caption-meta">
              <span>⚡ ४५ मिनट पहले</span>
              <span>📌 लखनऊ / उत्तर प्रदेश</span>
            </div>
          </div>
        </div>

        <!-- dots for slides -->
        <?php if(count($heroImages) > 1): ?>
        <div class="hero-dots">
          <?php foreach($heroImages as $dotIdx => $img): ?>
            <button class="hero-dot <?php echo $dotIdx === 0 ? 'active' : ''; ?>" data-slide-target="<?php echo $dotIdx; ?>" aria-label="slide <?php echo $dotIdx+1; ?>"></button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- right summary: natural headlines brief -->
      <div class="hero-summary">
        <div class="summary-kicker">आज की सुर्खियाँ</div>
        <div class="summary-headline">ताज़ा अपडेट्स, बिना शोर के</div>
        <div class="summary-text">लखनऊ समेत पश्चिमी यूपी की अहम ख़बरें, सटीक और तेज़।</div>
        <ul class="mini-headlines">
          <?php 
          $topThree = array_slice($news, 0, 4);
          foreach($topThree as $i => $item): 
          ?>
            <li><span>0<?php echo $i+1; ?></span> <a href="#"><?php echo htmlspecialchars(substr($item,0,50)) . (strlen($item)>50?'…':''); ?></a></li>
          <?php endforeach; ?>
          <?php if(count($news) < 2): ?>
            <li><span>01</span> <a href="#">स्मार्ट सिटी मिशन: 12 नए प्रोजेक्ट मंजूर</a></li>
            <li><span>02</span> <a href="#">मौसम विभाग का अलर्ट, बारिश के आसार</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </section>

  <!-- main content: latest updates in grid -->
  <main class="content-area">
    <div class="section-header">
      <h2>📰 ताज़ा समाचार · ब्रेकिंग अपडेट</h2>
      <span class="badge"><?php echo count($news); ?> अपडेट्स</span>
    </div>

    <div class="news-grid">
      <?php if(count($news) > 0): ?>
        <?php foreach(array_slice($news, 0, 8) as $newsItem): ?>
          <article class="news-card">
            <div class="card-category">⚡ BREAKING</div>
            <p><?php echo htmlspecialchars($newsItem); ?></p>
            <div class="time-indicator">🕒 अभी अभी</div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="no-news">
          <p style="font-weight:500;">फिलहाल कोई सक्रिय ब्रेकिंग नहीं है, लेकिन पुरानी खबरें देखें।</p>
          <p style="color:#6e8b9f;">प्रशासनिक अपडेट जल्द…</p>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <footer class="footer">
    © <?php echo date('Y'); ?> Lucknow Live24 — एक प्राकृतिक समाचार प्रारूप। सभी अधिकार सुरक्षित।
  </footer>
</div>

<!-- simple slider script (dots + autoplay) -->
<script>
  (function() {
    const slides = document.querySelectorAll('.slide-img');
    const dots = document.querySelectorAll('.hero-dot');
    let currentIdx = 0;

    if (!slides.length) return;

    function activateSlide(index) {
      slides.forEach((s, i) => {
        s.classList.toggle('active', i === index);
      });
      if (dots.length) {
        dots.forEach((d, i) => {
          d.classList.toggle('active', i === index);
        });
      }
      currentIdx = index;
    }

    // autoplay only if more than one slide
    if (slides.length > 1) {
      setInterval(() => {
        let next = (currentIdx + 1) % slides.length;
        activateSlide(next);
      }, 4200);
    }

    // dot click
    if (dots.length) {
      dots.forEach((dot, idx) => {
        dot.addEventListener('click', function() {
          const target = this.getAttribute('data-slide-target');
          if (target !== null) {
            activateSlide(parseInt(target));
          } else {
            // fallback if using data-slide-target
            const index = Array.from(dots).indexOf(this);
            activateSlide(index);
          }
        });
        // ensure data attribute
        if (!dot.hasAttribute('data-slide-target')) {
          dot.setAttribute('data-slide-target', idx);
        }
      });
    }

    // if no active set first active
    if (!slides[currentIdx]?.classList.contains('active')) {
      activateSlide(0);
    }
  })();
</script>
</body>
</html>