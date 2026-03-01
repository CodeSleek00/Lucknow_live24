<?php
include_once __DIR__ . '/../admin/db_connect.php';
include_once __DIR__ . '/../admin/news/news_helpers.php';

ensure_news_schema($conn);

$siteBreaking = [];
$breakingResult = mysqli_query($conn, "SELECT news_text FROM breaking_news WHERE status=1 ORDER BY id DESC LIMIT 20");
if($breakingResult){
    while($item = mysqli_fetch_assoc($breakingResult)){
        $siteBreaking[] = $item['news_text'];
    }
}

$siteHeroImages = [];
$heroResult = mysqli_query($conn, "SELECT image FROM hero_images ORDER BY id DESC");
if($heroResult){
    while($item = mysqli_fetch_assoc($heroResult)){
        $siteHeroImages[] = $item['image'];
    }
}

function esc(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function fetch_posts(mysqli $conn, int $limit = 10, string $where = '1=1'): array {
    $rows = [];
    $limit = max(1, $limit);
    $query = "
        SELECT
            p.*,
            (
                SELECT m.file_name
                FROM news_media m
                WHERE m.post_id = p.id
                ORDER BY m.sort_order ASC, m.id ASC
                LIMIT 1
            ) AS cover_media,
            (
                SELECT m.media_type
                FROM news_media m
                WHERE m.post_id = p.id
                ORDER BY m.sort_order ASC, m.id ASC
                LIMIT 1
            ) AS cover_type
        FROM news_posts p
        WHERE $where
        ORDER BY p.id DESC
        LIMIT $limit
    ";

    $result = mysqli_query($conn, $query);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
    }

    return $rows;
}

function short_text(string $text, int $limit = 150): string {
    $text = trim($text);
    if(strlen($text) <= $limit){
        return $text;
    }
    return rtrim(substr($text, 0, $limit)) . '...';
}

function get_cover_path(?string $fileName, ?string $type, array $heroImages): string {
    if($fileName && $type){
        return 'admin/news/uploads/' . rawurlencode($fileName);
    }

    if(isset($heroImages[0]) && $heroImages[0] !== ''){
        return 'admin/hero/uploads/' . rawurlencode($heroImages[0]);
    }

    return '';
}

function current_page_slug(): string {
    $script = basename($_SERVER['PHP_SELF'] ?? 'index.php');
    return strtolower($script);
}
