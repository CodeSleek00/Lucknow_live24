<!DOCTYPE html>
<html>
<head>
    <title>News Channel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="breaking-bar">
    <span class="label">BREAKING NEWS</span>
    <div class="ticker">
        <span id="breakingText">Loading...</span>
    </div>
</div>

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
