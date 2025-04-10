<?php

use models\User;

/** @var array $countriesArray */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/favicon.ico">

    <title>Traveler - Home</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'tours_style.css'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'search_bar/css_includes.php'?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main class="tours">
        <h1 class="tours-header cool-header">
            <span class="header-text">
                Оберіть <span class="underline">найкращий</span> тур
            </span>
        </h1>
        <?php include 'search_bar/search_bar.php'?>
        <div class="flex-tours">
            <?php foreach ($countriesArray as $country) : ?>
                <div class="country">
                    <div class="country-header">
                        <a href="/tours/search?country=<?= $country['en_name']?>">
                        <span class="flag">
                            <img src="/files/countries/flags/<?= $country['flag']?>" alt="<?= $country['en_name']?>-flag"/>
                        </span>
                            <span class="name"><?= $country['ua_name']?></span>
                        </a>
                    </div>
                    <div class="cities-scroll-bar">
                        <div class="cities">
                            <?php foreach ($country['cities'] as $city) : ?>
                                <div class="city-wrapper">
                                    <a href="/tours/search?country=<?= $country['en_name']?>&city=<?= $city['link']?>">
                                        <span class="flag">
                                            <img src="/files/countries/city/<?= $city['flag']?>" alt="<?= $city['link']?>-flag"/>
                                        </span>
                                        <span class="name"><?= $city['name']?></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="bg">
                        <div class="filter"></div>
                        <img src="/files/countries/covers/<?= $country['cover']?>" alt="<?= $country['en_name']?>-cover"/>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>


<script>
    <?php include 'views/components/header/header_script.js' ?>
    <?php include 'search_bar/js_includes.php'?>
</script>
</body>
</html>