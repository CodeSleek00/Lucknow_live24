<?php

function ensure_news_schema(mysqli $conn): void {
    mysqli_query($conn, "
        CREATE TABLE IF NOT EXISTS news_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            summary TEXT NULL,
            content LONGTEXT NOT NULL,
            author_name VARCHAR(120) NOT NULL,
            status TINYINT(1) NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");

    mysqli_query($conn, "
        CREATE TABLE IF NOT EXISTS news_media (
            id INT AUTO_INCREMENT PRIMARY KEY,
            post_id INT NOT NULL,
            media_type ENUM('image', 'video') NOT NULL,
            file_name VARCHAR(255) NOT NULL,
            sort_order INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_post_id (post_id),
            INDEX idx_sort_order (sort_order)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ");
}

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim((string)$text, '-');
    return $text !== '' ? $text : 'news';
}

function unique_slug(mysqli $conn, string $title, int $ignoreId = 0): string {
    $base = slugify($title);
    $slug = $base;
    $counter = 1;

    while(true){
        $escapedSlug = mysqli_real_escape_string($conn, $slug);
        $whereIgnore = $ignoreId > 0 ? " AND id != " . (int)$ignoreId : "";
        $check = mysqli_query($conn, "SELECT id FROM news_posts WHERE slug='$escapedSlug' $whereIgnore LIMIT 1");

        if($check && mysqli_num_rows($check) === 0){
            return $slug;
        }

        $counter++;
        $slug = $base . '-' . $counter;
    }
}

function split_paragraphs(string $content): array {
    $content = trim($content);
    if($content === ''){
        return [];
    }

    $parts = preg_split('/\R{2,}/', $content);
    $paragraphs = [];
    foreach($parts as $part){
        $p = trim((string)$part);
        if($p !== ''){
            $paragraphs[] = $p;
        }
    }

    return $paragraphs;
}

function media_url(string $fileName): string {
    return 'admin/news/uploads/' . rawurlencode($fileName);
}

function render_news_content_with_media(string $content, array $mediaRows): string {
    $paragraphs = split_paragraphs($content);
    if(count($paragraphs) === 0){
        return '';
    }

    $totalParagraphs = count($paragraphs);
    $bucket = [];

    foreach($mediaRows as $index => $item){
        $position = $index + 1;
        if($position > $totalParagraphs){
            $position = $totalParagraphs;
        }

        if(!isset($bucket[$position])){
            $bucket[$position] = [];
        }

        $bucket[$position][] = $item;
    }

    ob_start();
    foreach($paragraphs as $i => $paragraph){
        $position = $i + 1;
        echo '<p>' . nl2br(htmlspecialchars($paragraph)) . '</p>';

        if(isset($bucket[$position])){
            foreach($bucket[$position] as $media){
                $url = media_url($media['file_name']);
                if($media['media_type'] === 'image'){
                    echo '<figure class="news-media"><img src="' . htmlspecialchars($url) . '" alt="News image"></figure>';
                } else {
                    echo '<figure class="news-media">';
                    echo '<video controls preload="metadata">';
                    echo '<source src="' . htmlspecialchars($url) . '">';
                    echo 'Your browser does not support video.';
                    echo '</video>';
                    echo '</figure>';
                }
            }
        }
    }

    return (string)ob_get_clean();
}
