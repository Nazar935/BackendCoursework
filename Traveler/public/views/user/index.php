<?php

/** @var bool $isCurrentUser */
/** @var bool $isUserModerator */
/** @var bool $isCurrentUserModerator */
/** @var array-key $user */
/** @var array $savedTours */
/** @var array $bookingArray */

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
        <?php include 'views/tours/search_page/small_tour_styles.css'?>
        <?php include 'views/tours/search_page/search_page_style.css'?>
        <?php include 'views/tours/view/save/save_button_style.css'?>
        <?php include 'pfp_styles.css'?>
        <?php include 'index_style.css'?>
        <?php include 'views/admin/booking_admin/booking_list_styles.css'?>
    </style>
</head>

<body>
    <?php include 'views/components/header/header.php'?>
    <div class="scroll-bar">
        <main class="user-view-wrapper">
            <h1 class="tours-header cool-header">
                <span class="header-text">
                    Профіль <span class="underline">користувача</span>
                </span>
            </h1>
            <div class="user-view">
                <div class="profile">
                    <div class="profile-picture">
                        <div class="pfp" style="background: <?= $user['picture']['background'] ?>">
                            <span style="color: <?= $user['picture']['font_color'] ?>"><?= $user['picture']['letter'] ?></span>
                        </div>
                    </div>
                    <div class="info">
                        <div class="username"><?= $user['username'] ?></div>
                        <div class="description">Дата реєстрації: <?= $user['registration_date'] ?></div>
                        <?php if ($user['blocked']) : ?>
                            <div class="banned">Banned</div>
                        <?php endif; ?>
                    </div>
                    <div class="logout">
                        <?php if ($isCurrentUserModerator && !$isUserModerator) : ?>
                            <button class="button block-button <?= $user['blocked']? 'unblock' : '' ?>" data-user-id="<?= $user['id'] ?>">
                                <?php if ($user['blocked']) : ?>
                                    <span class="material-symbols-rounded">remove</span>
                                <?php endif; ?>
                                <span class="material-symbols-rounded">block</span>

                            </button>
                        <?php endif; ?>
                        <?php if ($isCurrentUser) :?>
                            <a class="button" href="/user/logout">
                                <span class="material-symbols-rounded">logout</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <?php if ($isCurrentUser || $isCurrentUserModerator) : ?>
                        <div class="booking-list-wrapper">
                            <h2>Мої бронювання</h2>
                            <div class="booking-list history">
                                <?php foreach ($bookingArray as $index => $booking) : ?>
                                    <div class="booking" data-booking-id="<?= $booking['booking_id'] ?>">
                                        <div class="index"><?= $index + 1 ?>.</div>
                                        <div class="tour-info">
                                            <div class="tour-name"><?= $booking['tour']['name'] ?></div>
                                            <a class="checkout-link" href="/checkout/view/<?= $booking['booking_id'] ?>">Детальніше...</a>
                                        </div>
                                        <div class="booking-info">
                                            <div class="date"><?= $booking['check_in'] ?></div>
                                            <div class="days"><?= $booking['days_str'] ?></div>
                                            <div class="tourists"><?= $booking['tourists_str'] ?></div>
                                        </div>
                                        <div class="buttons">
                                            <div class="status">
                                                <?php if ($booking['status'] == 0) : ?>
                                                    <span class="icon pending">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M280-420q25 0 42.5-17.5T340-480q0-25-17.5-42.5T280-540q-25 0-42.5 17.5T220-480q0 25 17.5 42.5T280-420Zm200 0q25 0 42.5-17.5T540-480q0-25-17.5-42.5T480-540q-25 0-42.5 17.5T420-480q0 25 17.5 42.5T480-420Zm200 0q25 0 42.5-17.5T740-480q0-25-17.5-42.5T680-540q-25 0-42.5 17.5T620-480q0 25 17.5 42.5T680-420ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                    </span>
                                                    <span class="text">В обробці</span>
                                                <?php elseif ($booking['status'] == 1) : ?>
                                                    <span class="icon check">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m424-408-86-86q-11-11-28-11t-28 11q-11 11-11 28t11 28l114 114q12 12 28 12t28-12l226-226q11-11 11-28t-11-28q-11-11-28-11t-28 11L424-408Zm56 328q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                    </span>
                                                    <span class="text">Ухвалено</span>
                                                <?php else : ?>
                                                    <span class="icon denial">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m480-424 116 116q11 11 28 11t28-11q11-11 11-28t-11-28L536-480l116-116q11-11 11-28t-11-28q-11-11-28-11t-28 11L480-536 364-652q-11-11-28-11t-28 11q-11 11-11 28t11 28l116 116-116 116q-11 11-11 28t11 28q11 11 28 11t28-11l116-116Zm0 344q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                    </span>
                                                    <span class="text">Відмовлено</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($isCurrentUserModerator) : ?>
                                                <div class="buttons-row">
                                                    <button class="check" data-status="0">
                                                        <span class="icon pending">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M280-420q25 0 42.5-17.5T340-480q0-25-17.5-42.5T280-540q-25 0-42.5 17.5T220-480q0 25 17.5 42.5T280-420Zm200 0q25 0 42.5-17.5T540-480q0-25-17.5-42.5T480-540q-25 0-42.5 17.5T420-480q0 25 17.5 42.5T480-420Zm200 0q25 0 42.5-17.5T740-480q0-25-17.5-42.5T680-540q-25 0-42.5 17.5T620-480q0 25 17.5 42.5T680-420ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                        </span>
                                                    </button>
                                                    <?php if ($booking['status'] == 1) : ?>
                                                        <button class="denial" data-status="2">
                                                            <span class="icon denial">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m480-424 116 116q11 11 28 11t28-11q11-11 11-28t-11-28L536-480l116-116q11-11 11-28t-11-28q-11-11-28-11t-28 11L480-536 364-652q-11-11-28-11t-28 11q-11 11-11 28t11 28l116 116-116 116q-11 11-11 28t11 28q11 11 28 11t28-11l116-116Zm0 344q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                            </span>
                                                        </button>
                                                    <?php else : ?>
                                                        <button class="check" data-status="1">
                                                            <span class="icon check">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m424-408-86-86q-11-11-28-11t-28 11q-11 11-11 28t11 28l114 114q12 12 28 12t28-12l226-226q11-11 11-28t-11-28q-11-11-28-11t-28 11L424-408Zm56 328q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                                            </span>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($booking['status'] == 0) : ?>
                                                <div class="delete-button-wrapper">
                                                    <button class="delete-button">
                                                        <span class="icon delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM400-280q17 0 28.5-11.5T440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280Zm160 0q17 0 28.5-11.5T600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280ZM280-720v520-520Z"/></svg>
                                                        </span>
                                                        <span class="text">Відмінити</span>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="saved-tours small-tour-list">
                        <h2>Список збережених турів</h2>
                        <div class="saved-tours-wrapper">
                            <div class="placeholder">
                                <div class="text">
                                    Немає збережених
                                </div>
                            </div>
                            <?php foreach ($savedTours as $tour) : ?>
                                <div class="tour-wrapper">
                                    <button class="save-button saved" data-tour-id="<?= $tour['tour_id'] ?>">
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#FF8C00" viewBox="0 -960 960 960" ><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Zm-38-543q-29-41-62-62.5T300-774q-60 0-100 40t-40 100q0 52 37 110.5T285.5-410q51.5 55 106 103t88.5 79q34-31 88.5-79t106-103Q726-465 763-523.5T800-634q0-60-40-100t-100-40q-47 0-80 21.5T518-690q-7 10-17 15t-21 5q-11 0-21-5t-17-15Zm38 189Z"/></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-147q-14 0-28.5-5T426-168l-69-63q-106-97-191.5-192.5T80-634q0-94 63-157t157-63q53 0 100 22.5t80 61.5q33-39 80-61.5T660-854q94 0 157 63t63 157q0 115-85 211T602-230l-68 62q-11 11-25.5 16t-28.5 5Z"/></svg>
                                    </span>
                                    </button>
                                    <a class="tour" href="/tours/view/<?= $tour['link'] ?>">
                                        <div class="cover">
                                            <img src="/files/tours/pictures/<?= $tour['photo_list'][0] ?>" alt="slider-photo-4"/>
                                        </div>
                                        <div class="tour-info">
                                            <div class="name-wrapper">
                                                <div class="stars">
                                                    <?php for ($i = 0; $i < $tour['stars']; $i++) : ?>
                                                        <span class="material-symbols-rounded">star</span>
                                                    <?php endfor; ?>
                                                </div>
                                                <div class="name"><?= $tour['name'] ?></div>
                                                <div class="description">
                                                    <?= $tour['country']['ua_name'] ?>,
                                                    <?= $tour['city']['name'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <?php include 'views/components/footer/footer.php'?>
    </div>

</body>
<script>
    <?php include 'views/components/header/header_script.js'?>
    <?php include 'views/tours/view/save/save_button_script.js'?>
    <?php include 'user_view_script.js'?>
    <?php include 'views/admin/booking_admin/change_status_script.js' ?>
</script>
</html>