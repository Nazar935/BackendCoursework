<?php

use models\Review;
use models\User;
/** @var array $reviews */
/** @var bool $isModer */
/** @var bool $isLoggedIn */
/** @var array-key $user */
/** @var int $page */
/** @var int $pagesCount */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/favicon.ico">

    <title>Traveler - Home</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'reviews_style.css'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'views/components/photo_slider/photo_slider_style.css'?>
        <?php
            if ($isLoggedIn)
                include 'new/new_review_style.css';
        ?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>
<div class="scroll-bar">


    <main class="reviews">
        <h1 class="page-header cool-header">
            <span class="header-text">
                Відгуки про турагенцію <span class="underline">Traveler</span>
            </span>
        </h1>
        <div class="reviews-component">

            <?php
            if ($isLoggedIn)
                include 'new/new_review.php';
            ?>
            <div class="reviews-box">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-wrapper">
                        <div class="review" data-id="<?= $review['review_id']?>">
                            <div class="author">
                                <div class="left">
                                    <div class="pfp" style="background: <?= $review['author']['picture']['background'] ?>">
                                        <span style="color: <?= $review['author']['picture']['font_color'] ?>"><?= $review['author']['picture']['letter'] ?></span>
                                    </div>
                                    <div class="name">
                                        <a href="/user/view/<?= $review['author']['username']?>">
                                            <?= $review['author']['username']?>
                                        </a>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="date">
                                        <?= $review['date']?>
                                    </div>
                                    <?php if ($isModer || (!is_null($user) && Review::isUserReview($review['review_id'], $user['id']))): ?>
                                        <div class="delete-button-wrapper">
                                            <button class="delete-button">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </div>
                                    <?php endif;?>
                                </div>

                            </div>
                            <div class="line"></div>
                            <div class="text">
                                <?= $review['text']?>
                            </div>
                            <div class="button-wrapper full-text-button">
                                <button class="read-more">
                                    <span>Read more</span>
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </div>
                            <?php if (count($review['photo_list']) > 0) :?>
                                <div class="line"></div>
                                <div class="photo-list">
                                    <?php foreach ($review['photo_list'] as $photo): ?>
                                        <div class="review-photo">
                                            <img src="/files/review_photos/<?= $photo?>">
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="page-slider"
                 data-page="<?= $page?>"
                 data-pages-count="<?= $pagesCount?>"
                 data-is-moder="<?= $isModer ?>"
            >
                <a  class="left disabled" aria-disabled="true">
                    <i class="material-icons">chevron_left</i>
                </a>
                <a href="/reviews/page/1" class="current-page">1</a>
                <a href="/reviews/page/2">2</a>
                <a href="/reviews/page/3">3</a>
                <a href="/reviews/page/4">4</a>
                <a href="/reviews/page/5">5</a>
                <div class="middle-part">...</div>
                <a href="/reviews/page/5">10</a>
                <a href="/reviews/page/3" class="right">
                    <i class="material-icons">chevron_right</i>
                </a>
            </div>
        </div>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>

<?php include 'views/components/photo_slider/photo_slider.php' ?>

<script>
    <?php include 'views/components/header/header_script.js' ?>
    <?php include 'reviews_script.js'?>
    <?php include 'views/components/photo_slider/photo_slider.js'?>
    <?php
        if ($isLoggedIn)
        {
            include 'new/new_review_script.js';
            include 'new/drag_and_drop.js';
        }
    ?>
</script>
</body>
</html>