<?php

use models\User;

/** @var array $toursArray */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/favicon.ico">

    <title>Traveler - Home</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'views/tours/tours_style.css'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'views/tours/search_bar/css_includes.php'?>
        <?php include 'search_page_style.css'?>
        <?php include 'filters/filters_styles.php'?>
        <?php include 'views/tours/view/save/save_button_style.css'?>
        <?php include 'small_tour_styles.css'?>

    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main>
        <h1 class="tours-header cool-header">
            <span class="header-text">
                Оберіть <span class="underline">найкращий</span> тур
            </span>
        </h1>
        <?php include 'views/tours/search_bar/search_bar.php'?>
        <div class="search-page">
            <?php include 'filters/filters.php'?>
            <div class="search-results small-tour-list" >
                <div class="placeholder" style="display: none">Жодного туру не знайдено, спробуйте змінити параметри пошуку</div>
            </div>
        </div>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>


<script>
    <?php include 'views/components/header/header_script.js'?>
    <?php include 'views/tours/search_bar/js_includes.php'?>
    <?php include 'search_page_script.js'?>
    <?php include 'filters/filters_scripts.php'?>
    <?php include 'views/tours/view/save/save_button_script.js'?>
</script>
</body>
</html>