<?php
session_start();
include "../db_connect.php";

if(!isset($_SESSION['admin'])){
    header("Location: ../admin_login.php");
    exit();
}

if(!isset($_FILES['image'])){
    header("Location: hero_admin.php?status=error&msg=" . urlencode("No file selected."));
    exit();
}

$file = $_FILES['image'];
if($file['error'] !== UPLOAD_ERR_OK){
    header("Location: hero_admin.php?status=error&msg=" . urlencode("Upload failed. Please try again."));
    exit();
}

$tmp = $file['tmp_name'];
$originalName = basename($file['name']);
$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
$allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

if(!in_array($extension, $allowedExt, true)){
    header("Location: hero_admin.php?status=error&msg=" . urlencode("Only JPG, JPEG, PNG, WEBP allowed."));
    exit();
}

$mime = mime_content_type($tmp);
$allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
if($mime === false || !in_array($mime, $allowedMime, true)){
    header("Location: hero_admin.php?status=error&msg=" . urlencode("Invalid image file type."));
    exit();
}

$uploadDir = __DIR__ . "/uploads";
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0755, true);
}

if(!is_writable($uploadDir)){
    header("Location: hero_admin.php?status=error&msg=" . urlencode("Upload folder not writable."));
    exit();
}

$safeBase = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
if($safeBase === ''){
    $safeBase = 'hero_image';
}
$newName = $safeBase . '_' . time() . '.' . $extension;
$targetPath = $uploadDir . "/" . $newName;

if(!move_uploaded_file($tmp, $targetPath)){
    header("Location: hero_admin.php?status=error&msg=" . urlencode("Failed to save image."));
    exit();
}

$escapedName = mysqli_real_escape_string($conn, $newName);
$insert = mysqli_query($conn, "INSERT INTO hero_images(image) VALUES('$escapedName')");
if(!$insert){
    @unlink($targetPath);
    header("Location: hero_admin.php?status=error&msg=" . urlencode("DB save failed."));
    exit();
}

header("Location: hero_admin.php?status=success&msg=" . urlencode("Image uploaded successfully."));
?>
