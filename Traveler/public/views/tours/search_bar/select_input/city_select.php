<?php

/** @var array $searchParams */
/** @var array $countriesArray */

?>

<div class="city-select select"
    <?= array_key_exists("city", $searchParams)? "data-search=" . $searchParams['city'] : ""?>
>
    <button class="search-bar-header">
        <i class="material-icons">location_city</i>
        <span class="text">Місто</span>
        <div class="arrow-wrapper">
            <i class="material-icons">chevron_right</i>
        </div>
    </button>
    <div class="drop-down hide">
        <div class="drop-menu">
                <div class="options drop-down-scroll-bar no-country" data-country="no-country">
                    Спочатку оберіть країну
                </div>
            <?php foreach ($countriesArray as $country) : ?>
                <div class="options drop-down-scroll-bar hidden-options" data-country="<?= $country['en_name']?>">
                    <?php foreach ($country['cities'] as $city) : ?>
                        <button class="option" data-option="<?= $city['link']?>">
                            <span class="arrow">
                                <i class="material-icons">chevron_right</i>
                            </span>
                            <span class="image-wrapper">
                                <img src="/files/countries/city/<?= $city['flag']?>"/>
                            </span>
                            <span class="text"><?= $city['name']?></span>
                        </button>
                        <div class="line"></div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>

        </div>
        <div class="clear hide">
            <button>
                <span>
                    <i class="material-icons">backspace</i>
                </span>
                <span>Очистити поле</span>
            </button>
        </div>
    </div>
</div>
