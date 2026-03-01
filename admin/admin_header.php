<?php
session_start();
$_selfPath = str_replace("\\", "/", $_SERVER['PHP_SELF'] ?? "");
$isNewsSubdir = strpos($_selfPath, "/admin/news/") !== false;
$prefix = $isNewsSubdir ? "../" : "";
$newsLink = $isNewsSubdir ? "news_admin.php" : "news/news_admin.php";

if(!isset($_SESSION['admin'])){
    header("Location: " . $prefix . "admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="<?php echo $prefix; ?>admin_style.css">
</head>
<body>

<div class="sidebar">
    <h2>NEWS ADMIN</h2>
    <a href="<?php echo $prefix; ?>admin_dashboard.php">Dashboard</a>
    <a href="<?php echo $prefix; ?>add_breaking.php">Add Breaking</a>
    <a href="<?php echo $prefix; ?>manage_breaking.php">Manage Breaking</a>
    <a href="<?php echo $newsLink; ?>">Manage News Posts</a>
    <a href="<?php echo $prefix; ?>hero/hero_admin.php">Manage Hero Images</a>
    <a href="<?php echo $prefix; ?>admin_logout.php">Logout</a>
</div>

<div class="main">
