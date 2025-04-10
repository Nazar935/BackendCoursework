<?php

/** @var array $countryArray */

?>

<div class="slider">
    <div class="arrows">
        <div class="button-wrapper">
            <button id="previous" class="left">
                <i class="material-icons">arrow_back</i>
            </button>
        </div>
        <div class="button-wrapper">
            <button id="next" class="right">
                <i class="material-icons">arrow_forward</i>
            </button>
        </div>
    </div>
    <div class="video-bg">
        <div class="video">
            <a class="slide-text" href="/tours/search?country=japan">
                <span class="pattern">JAPAN</span>
                <span class="text">JAPAN</span>
            </a>
            <video loop preload="auto" autoplay muted disablePictureInPicture >
                <source src="/files/static/slideshow/japan.webm" type="video/webm"/>
            </video>
        </div>

    </div>
</div>

<script>
    const countriesArray = [
        <?php foreach ($countryArray as $country) : ?>
            {
                name: "<?= strtoupper($country['en_name'])?>",
                backgroundVideo: "/files/countries/videos/<?= $country['video']?>",
                letterPattern: "/files/countries/patterns/<?= $country['pattern']?>",
                link: "/tours/search?country=<?= $country['en_name']?>"
            },
        <?php endforeach; ?>
    ]
</script>
