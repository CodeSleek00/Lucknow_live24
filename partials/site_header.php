<?php
$pageTitle = $pageTitle ?? 'Lucknow Live24';
$activeNav = $activeNav ?? current_page_slug();

$navItems = [
    'index.php' => 'Home',
    'latest.php' => 'Latest News',
    'videos.php' => 'Videos',
    'category.php' => 'Categories',
    'about.php' => 'About',
    'contact.php' => 'Contact'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc($pageTitle); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="site.css">
</head>
<body>
<div class="site-shell">
    <header class="site-header">
        <div class="brand-wrap">
            <button class="menu-toggle" id="menuToggle" aria-expanded="false" aria-controls="mobileNav" aria-label="Open navigation">
                <span></span><span></span><span></span>
            </button>
            <a class="brand" href="index.php">
                <span class="brand-mark"></span>
                <span class="brand-text">Lucknow <b>Live24</b></span>
            </a>
        </div>

        <nav class="desktop-nav" aria-label="Main navigation">
            <?php foreach($navItems as $link => $label): ?>
                <a href="<?php echo esc($link); ?>" class="<?php echo $activeNav === $link ? 'active' : ''; ?>"><?php echo esc($label); ?></a>
            <?php endforeach; ?>
        </nav>

        <div class="header-meta">
            <span><?php echo date('D, d M Y'); ?></span>
        </div>
    </header>

    <aside class="mobile-drawer" id="mobileNav" aria-hidden="true">
        <div class="drawer-head">
            <strong>Explore</strong>
            <button id="menuClose" aria-label="Close navigation">×</button>
        </div>
        <nav class="drawer-nav">
            <?php foreach($navItems as $link => $label): ?>
                <a href="<?php echo esc($link); ?>" class="<?php echo $activeNav === $link ? 'active' : ''; ?>"><?php echo esc($label); ?></a>
            <?php endforeach; ?>
        </nav>
    </aside>
    <div class="drawer-backdrop" id="drawerBackdrop"></div>

    <div class="breaking-bar">
        <div class="breaking-pill">Breaking</div>
        <div class="breaking-track">
            <div class="breaking-text">
                <?php if(count($siteBreaking) > 0): ?>
                    <?php foreach($siteBreaking as $line): ?>
                        <span>• <?php echo esc($line); ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span>• No active breaking updates yet.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
