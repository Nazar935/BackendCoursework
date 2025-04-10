<?php

/** @var array $searchParams */
/** @var array $countriesArray */

?>

<div class="country-select select"
    <?= array_key_exists("country", $searchParams)? "data-search=" . $searchParams['country'] : ""?>
>
    <button class="search-bar-header">
        <i class="material-icons">map</i>
        <span class="text">Країна</span>
        <div class="arrow-wrapper">
            <i class="material-icons">chevron_right</i>
        </div>
    </button>
    <div class="drop-down  hide">
        <div class="drop-menu">
            <div class="options drop-down-scroll-bar">
                <?php foreach ($countriesArray as $country) : ?>
                    <button class="option" data-option="<?= $country['en_name']?>">
                        <span class="arrow">
                            <i class="material-icons">chevron_right</i>
                        </span>
                        <span class="image-wrapper">
                            <img src="/files/countries/flags/<?= $country['flag']?>"/>
                        </span>
                        <span class="text"><?= $country['ua_name']?></span>
                    </button>
                    <div class="line"></div>
                <?php endforeach; ?>
            </div>
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