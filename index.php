<?php
include 'admin/db_connect.php';

$q = mysqli_query($conn, "
    SELECT news_text, created_at 
    FROM breaking_news 
    WHERE status = 1 
    ORDER BY id DESC
");
?>

<section class="breaking-section">
    <h2 class="breaking-title">Latest Updates</h2>

    <div class="breaking-list">
        <?php 
        if(mysqli_num_rows($q) > 0){
            while($row = mysqli_fetch_assoc($q)){
        ?>
            <div class="breaking-item">
                <span class="dot">🔴</span>
                <span class="text"><?= $row['news_text'] ?></span>
                <span class="time">
                    <?= date("d M Y", strtotime($row['created_at'])) ?>
                </span>
            </div>
        <?php 
            }
        } else {
            echo "<p>No news available</p>";
        }
        ?>
    </div>
</section>
