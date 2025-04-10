<?php

use models\User;
/** @var array $tour */
/** @var array $similarTours */
/** @var array $searchParams */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/favicon.ico">

    <title>Traveler - Home</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'views/tours/search_bar/css_includes.php'?>
        <?php include 'tour_view_style.css'?>
        <?php include 'save/save_button_style.css'?>
        <?php include 'booking/booking_styles.css'?>
        <?php include 'views/tours/search_page/small_tour_styles.css'?>
        <?php include 'views/components/photo_slider/photo_slider_style.css'?>
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
        <div class="tour-view">
            <div class="tour-header">
                <a href="#info">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                    </span>
                    <span class="text">Інформація</span>
                </a>
                <a href="#facilities">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M260-280q-26 0-43-17t-17-43q0-25 17-42.5t43-17.5q25 0 42.5 17.5T320-340q0 26-17.5 43T260-280Zm0-280q-26 0-43-17t-17-43q0-25 17-42.5t43-17.5q25 0 42.5 17.5T320-620q0 26-17.5 43T260-560Zm180 120q-17 0-28.5-11.5T400-480q0-17 11.5-28.5T440-520h80q17 0 28.5 11.5T560-480q0 17-11.5 28.5T520-440h-80Zm240-40q0-54-14.5-104T623-676q-9-14-8-31t14-28q13-11 29-8.5t26 16.5q36 53 56 115.5T760-480q0 56-13.5 107T709-276q-8 15-24 19t-30-5q-14-9-17.5-25.5T642-319q18-37 28-77t10-84Z"/></svg>
                    </span>
                    <span class="text">Зручності</span>
                </a>
                <a href="#map">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m574-129-214-75-186 72q-10 4-19.5 2.5T137-136q-8-5-12.5-13.5T120-169v-561q0-13 7.5-23t20.5-15l186-63q6-2 12.5-3t13.5-1q7 0 13.5 1t12.5 3l214 75 186-72q10-4 19.5-2.5T823-824q8 5 12.5 13.5T840-791v561q0 13-7.5 23T812-192l-186 63q-6 2-12.5 3t-13.5 1q-7 0-13.5-1t-12.5-3Zm-14-89v-468l-160-56v468l160 56Zm80 0 120-40v-474l-120 46v468Zm-440-10 120-46v-468l-120 40v474Zm440-458v468-468Zm-320-56v468-468Z"/></svg>
                    </span>
                    <span class="text">На карті</span>
                </a>
                <a href="#booking">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m480-240-168 72q-40 17-76-6.5T200-241v-519q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v519q0 43-36 66.5t-76 6.5l-168-72Zm0-88 200 86v-518H280v518l200-86Zm0-432H280h400-200Z"/></svg>
                    </span>
                    <span class="text">Бронювання</span>
                </a>
            </div>
            <div class="line" id="info"></div>
            <div class="info">
                <div class="info-header">
                    <div class="left">
                        <div class="stars">
                            <?php for ($i = 0; $i < $tour['stars']; $i++) : ?>
                                <span class="material-symbols-rounded">star</span>
                            <?php endfor; ?>
                        </div>
                        <div class="name"><?= $tour['name'] ?></div>
                        <div class="location">
                            <span class="text"><?= $tour['address'] ?> — </span>
                            <a href="#map">Показати на карті</a>
                        </div>
                    </div>
                    <div class="right">
                        <button class="save-button <?= $tour['is_saved'] ? 'saved' : '' ?>" data-tour-id="<?= $tour['tour_id'] ?>">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#FF8C00" viewBox="0 -960 960 960" ><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Zm-38-543q-29-41-62-62.5T300-774q-60 0-100 40t-40 100q0 52 37 110.5T285.5-410q51.5 55 106 103t88.5 79q34-31 88.5-79t106-103Q726-465 763-523.5T800-634q0-60-40-100t-100-40q-47 0-80 21.5T518-690q-7 10-17 15t-21 5q-11 0-21-5t-17-15Zm38 189Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Z"/></svg>
                            </span>
                        </button>
                        <button class="share">
                            <span class="material-symbols-rounded">share</span>
                        </button>
                        <button class="accent-button" id="fake-booking-button">
                            <span>Бронювати</span>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fcfcfc"><path d="M200-120v-640q0-33 23.5-56.5T280-840h400q33 0 56.5 23.5T760-760v640L480-240 200-120Zm80-122 200-86 200 86v-518H280v518Zm0-518h400-400Z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="info-slider" id="tour-photo-list">
                    <button class="left">
                        <img src="/files/tours/pictures/<?= $tour['photo_list'][0] ?>" alt="slider-photo-1"/>
                    </button>
                    <div class="grid">
                        <button>
                            <img src="/files/tours/pictures/<?= $tour['photo_list'][1] ?>" alt="slider-photo-2"/>
                        </button>
                        <button>
                            <img src="/files/tours/pictures/<?= $tour['photo_list'][2] ?>" alt="slider-photo-3"/>
                        </button>
                        <button>
                            <img src="/files/tours/pictures/<?= $tour['photo_list'][3] ?>" alt="slider-photo-4"/>
                        </button>
                        <button>
                            <span class="overlay">
                                +<?= count($tour['photo_list']) - 4 ?>
                            </span>
                            <img src="/files/tours/pictures/<?= $tour['photo_list'][4] ?>" alt="slider-photo-5"/>
                        </button>
                        <div style="display: none">
                            <?php for ($i = 5; $i < count($tour['photo_list']); $i++) : ?>
                                <img src="/files/tours/pictures/<?= $tour['photo_list'][$i] ?>" alt="slider-photo-<?= $i ?>"/>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="line"  id="facilities"></div>
            <div class="facilities">
                <div class="facilities-wrapper">
                    <h2>Зручності</h2>
                    <div class="list">

                        <?php foreach ($tour['facilities_array'] as $facility) : ?>
                            <div class="facility">
                                <span class="icon-wrapper">
                                    <img src="/files/facilities/<?= $facility['icon'] ?>" alt="wifi">
                                </span>
                                <span class="text"><?= $facility['name'] ?></span>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div class="info-map">
                    <div class="info-text">
                        <h2>Опис готелю</h2>
                        <div class="description">
                            <?= $tour['description'] ?>
                        </div>
                    </div>
                    <div class="map-wrapper" id="map">
                        <h2>Готель на карті</h2>
                        <div id="map-component" class="map"></div>
                        <a class="simple-button google-maps"  target="_blank" href="<?= $tour['google_maps_link'] ?>">
                            <span class="text">Google Maps</span>
                            <span class="icon">
                                <i class="material-icons">open_in_new</i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="line" id="booking"></div>
            <?php include 'booking/booking.php'?>
            <div class="line" id="similar"></div>
            <div class="similar">
                <h2>Схожі тури</h2>
                <div class="tours small-tour-list">
                    <?php foreach ($similarTours as $similarTour) : ?>
                        <div class="tour-wrapper">
                        <button class="save-button <?= $tour['is_saved']? 'saved' : ''?>" >
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#FF8C00" viewBox="0 -960 960 960" ><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Zm-38-543q-29-41-62-62.5T300-774q-60 0-100 40t-40 100q0 52 37 110.5T285.5-410q51.5 55 106 103t88.5 79q34-31 88.5-79t106-103Q726-465 763-523.5T800-634q0-60-40-100t-100-40q-47 0-80 21.5T518-690q-7 10-17 15t-21 5q-11 0-21-5t-17-15Zm38 189Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Z"/></svg>
                            </span>
                        </button>
                        <a class="tour" href="/tours/view/<?= $similarTour['link'] ?>">
                            <div class="cover">
                                <img src="/files/tours/pictures/<?= $similarTour['photo_list'][0] ?>" alt="slider-photo-4"/>
                            </div>
                            <div class="tour-info">
                                <div class="name-wrapper">
                                    <div class="stars">
                                        <?php for ($i = 0; $i < $similarTour['stars']; $i++) : ?>
                                            <span class="material-symbols-rounded">star</span>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="name"><?= $similarTour['name'] ?></div>
                                    <div class="description"><?= $similarTour['country']['ua_name'] ?>, <?= $similarTour['city']['name'] ?></div>
                                </div>
                                <div class="price-wrapper">
                                    <div class="description">За <?= \core\Utils::formatedDays($searchParams['days']) ?> , <?= \core\Utils::formatedTourists($searchParams['tourists']) ?> від </div>
                                    <div class="price">UAH 16,256.25</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>

<?php include 'views/components/photo_slider/photo_slider.php' ?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script>
    <?php include 'views/components/header/header_script.js'?>
    <?php include 'views/tours/search_bar/date_picker/date_picker_script.js'?>
    <?php include 'views/tours/search_bar/number_input/number_input_script.js'?>
    <?php include 'tour_view_script.js'?>
    <?php include 'booking/small_search_bar_script.js'?>
    <?php include 'booking/edited_select_script.js'?>
    <?php include 'views/tours/search_bar/top_panel/tab_script.js'?>
    <?php include 'map_script.js' ?>
    <?php include 'booking/booking_script.js'?>
    <?php include 'views/components/photo_slider/photo_slider.js'?>
    <?php include 'views/tours/view/save/save_button_script.js'?>
</script>
</body>
</html>