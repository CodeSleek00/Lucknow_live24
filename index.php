<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lucknow Live 24 – News Channel</title>
<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- ===== TOP HEADER ===== -->
<header class="top-header">
    <div class="logo">Lucknow Live <span>24</span></div>
    <nav>
        <a href="#">Home</a>
        <a href="#">Politics</a>
        <a href="#">Crime</a>
        <a href="#">Sports</a>
        <a href="#">Entertainment</a>
        <a href="#">Contact</a>
    </nav>
</header>

<!-- ===== BREAKING NEWS BAR ===== -->
<div class="breaking-bar">
    <span class="label">BREAKING</span>
    <div class="ticker">
        <span id="breakingText">Loading...</span>
    </div>
</div>

<!-- ===== MAIN CONTENT ===== -->
<section class="container">

    <!-- LEFT NEWS -->
    <div class="left">
        <div class="news-card">
            <img src="https://via.placeholder.com/400x220">
            <h3>Major political development in Lucknow today</h3>
            <p>Detailed news description will come here...</p>
        </div>

        <div class="news-card">
            <img src="https://via.placeholder.com/400x220">
            <h3>Big update from sports world</h3>
            <p>Match highlights and breaking updates...</p>
        </div>
    </div>

    <!-- RIGHT SIDEBAR -->
    <aside class="right">
        <h3>Latest Updates</h3>
        <ul>
            <li>🔴 Traffic update in city</li>
            <li>🔴 Weather alert issued</li>
            <li>🔴 Exam date announced</li>
            <li>🔴 Crime news update</li>
        </ul>
    </aside>

</section>

<!-- ===== FOOTER ===== -->
<footer>
    <p>© 2026 Lucknow Live 24 | All Rights Reserved</p>
</footer>

<!-- ===== BREAKING NEWS FETCH ===== -->
<script>
function loadBreaking(){
    fetch('fetch_breaking.php')
    .then(res => res.json())
    .then(data => {
        document.getElementById('breakingText').innerText =
            data.length ? data.join(' 🔴 ') : 'No Breaking News';
    });
}
loadBreaking();
setInterval(loadBreaking, 20000);
</script>

</body>
</html>
