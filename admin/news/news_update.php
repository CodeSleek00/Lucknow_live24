<?php
session_start();
include "../db_connect.php";
include "news_helpers.php";

if(!isset($_SESSION['admin'])){
    header("Location: ../admin_login.php");
    exit();
}

ensure_news_schema($conn);

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if($id <= 0){
    header("Location: news_admin.php?msg=" . urlencode("Invalid post."));
    exit();
}

$title = trim($_POST['title'] ?? '');
$authorName = trim($_POST['author_name'] ?? '');
$summary = trim($_POST['summary'] ?? '');
$content = trim($_POST['content'] ?? '');
$status = isset($_POST['status']) && (int)$_POST['status'] === 0 ? 0 : 1;

if($title === '' || $authorName === '' || $summary === '' || $content === ''){
    header("Location: news_edit.php?id=$id");
    exit();
}

$slug = unique_slug($conn, $title, $id);

$escTitle = mysqli_real_escape_string($conn, $title);
$escSlug = mysqli_real_escape_string($conn, $slug);
$escSummary = mysqli_real_escape_string($conn, $summary);
$escContent = mysqli_real_escape_string($conn, $content);
$escAuthor = mysqli_real_escape_string($conn, $authorName);

mysqli_query($conn, "
    UPDATE news_posts
    SET title='$escTitle', slug='$escSlug', summary='$escSummary', content='$escContent', author_name='$escAuthor', status=$status
    WHERE id=$id
");

$uploadDir = __DIR__ . '/uploads';

if(isset($_POST['delete_media']) && is_array($_POST['delete_media'])){
    foreach($_POST['delete_media'] as $mediaIdRaw){
        $mediaId = (int)$mediaIdRaw;
        if($mediaId <= 0){
            continue;
        }

        $mResult = mysqli_query($conn, "SELECT * FROM news_media WHERE id=$mediaId AND post_id=$id LIMIT 1");
        $media = $mResult ? mysqli_fetch_assoc($mResult) : null;
        if($media){
            $filePath = $uploadDir . '/' . $media['file_name'];
            if(file_exists($filePath)){
                unlink($filePath);
            }
            mysqli_query($conn, "DELETE FROM news_media WHERE id=$mediaId");
        }
    }
}

$allowedImages = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'webp' => 'image/webp'
];
$allowedVideos = [
    'mp4' => 'video/mp4',
    'webm' => 'video/webm',
    'ogg' => 'video/ogg'
];

$maxSort = 0;
$sortResult = mysqli_query($conn, "SELECT MAX(sort_order) AS max_sort FROM news_media WHERE post_id=$id");
if($sortResult){
    $row = mysqli_fetch_assoc($sortResult);
    $maxSort = (int)($row['max_sort'] ?? 0);
}
$sortOrder = $maxSort + 1;

if(isset($_FILES['media']) && is_array($_FILES['media']['name'])){
    $count = count($_FILES['media']['name']);
    for($i = 0; $i < $count; $i++){
        $err = $_FILES['media']['error'][$i] ?? UPLOAD_ERR_NO_FILE;
        if($err === UPLOAD_ERR_NO_FILE){
            continue;
        }
        if($err !== UPLOAD_ERR_OK){
            continue;
        }

        $tmp = $_FILES['media']['tmp_name'][$i];
        $originalName = basename((string)$_FILES['media']['name'][$i]);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $mime = mime_content_type($tmp);

        $mediaType = '';
        if(isset($allowedImages[$extension]) && $mime === $allowedImages[$extension]){
            $mediaType = 'image';
        } elseif(isset($allowedVideos[$extension]) && $mime === $allowedVideos[$extension]){
            $mediaType = 'video';
        } else {
            continue;
        }

        $size = (int)($_FILES['media']['size'][$i] ?? 0);
        if($mediaType === 'image' && $size > 6 * 1024 * 1024){
            continue;
        }
        if($mediaType === 'video' && $size > 40 * 1024 * 1024){
            continue;
        }

        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        if($base === '' || $base === null){
            $base = 'media';
        }

        $fileName = $base . '_' . time() . '_' . $i . '.' . $extension;
        $targetPath = $uploadDir . '/' . $fileName;

        if(!move_uploaded_file($tmp, $targetPath)){
            continue;
        }

        $escFile = mysqli_real_escape_string($conn, $fileName);
        $escType = mysqli_real_escape_string($conn, $mediaType);
        mysqli_query($conn, "
            INSERT INTO news_media(post_id, media_type, file_name, sort_order)
            VALUES($id, '$escType', '$escFile', $sortOrder)
        ");

        $sortOrder++;
    }
}

header("Location: news_admin.php?msg=" . urlencode("News post updated."));
