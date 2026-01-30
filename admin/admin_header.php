<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="sidebar">
    <h2>NEWS ADMIN</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="add_breaking.php">Add Breaking</a>
    <a href="manage_breaking.php">Manage Breaking</a>
    <a href="admin_logout.php">Logout</a>
</div>

<div class="main">
