<?php

use models\User;

/** @var array $bookedTour */
/** @var array $bookedRooms */
/** @var array $bookingDetails */
/** @var array $userInfo */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/logo.ico">

    <title>Traveler - Admin</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'checkout_styles.css'?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main class="checkout-page">
        <h1 class="cool-header">
            <span class="header-text">
                <?php if (!isset($userInfo)) : ?>
                    Оформлення <span class="underline">бронювання</span>
                <?php else: ?>
                    Деталі заявки на <span class="underline">бронювання</span>
                <?php endif; ?>
            </span>
        </h1>
        <div class="checkout">
            <div class="progress menu-card">
                <div class="bg">
                    <div class="line"></div>
                </div>
                <div class="label">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q48 0 93.5 11t87.5 32q15 8 19.5 24t-5.5 30q-10 14-26.5 18t-32.5-4q-32-15-66.5-23t-69.5-8q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-8-.5-15.5T798-511q-2-17 6.5-32.5T830-564q16-5 30 3t16 24q2 14 3 28t1 29q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-56-328 372-373q11-11 27.5-11.5T852-781q11 11 11 28t-11 28L452-324q-12 12-28 12t-28-12L282-438q-11-11-11-28t11-28q11-11 28-11t28 11l86 86Z"/></svg>
                    </div>
                    <div class="text">Оберіть тур</div>
                </div>
                <div class="label <?= !isset($userInfo) ? "current" : "" ?>">
                    <div class="icon">
                        <?php if (!isset($userInfo)) : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                        <?php else : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q48 0 93.5 11t87.5 32q15 8 19.5 24t-5.5 30q-10 14-26.5 18t-32.5-4q-32-15-66.5-23t-69.5-8q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-8-.5-15.5T798-511q-2-17 6.5-32.5T830-564q16-5 30 3t16 24q2 14 3 28t1 29q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-56-328 372-373q11-11 27.5-11.5T852-781q11 11 11 28t-11 28L452-324q-12 12-28 12t-28-12L282-438q-11-11-11-28t11-28q11-11 28-11t28 11l86 86Z"/></svg>
                        <?php endif; ?>
                    </div>
                    <div class="text">Введіть дані</div>
                </div>
                <div class="label <?= isset($userInfo) ? "current" : "next" ?>">
                    <div class="icon">
                        <?php if (isset($userInfo) && $userInfo['status'] == 1) : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q48 0 93.5 11t87.5 32q15 8 19.5 24t-5.5 30q-10 14-26.5 18t-32.5-4q-32-15-66.5-23t-69.5-8q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-8-.5-15.5T798-511q-2-17 6.5-32.5T830-564q16-5 30 3t16 24q2 14 3 28t1 29q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-56-328 372-373q11-11 27.5-11.5T852-781q11 11 11 28t-11 28L452-324q-12 12-28 12t-28-12L282-438q-11-11-11-28t11-28q11-11 28-11t28 11l86 86Z"/></svg>
                        <?php else : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                        <?php endif; ?>
                    </div>
                    <div class="text">Підтвердження</div>
                </div>
            </div>
            <div class="grid">
                <div class="left">
                    <a href="/tours/view/<?= $bookedTour['link'] ?>" class="tour menu-card">
                        <img src="/files/tours/pictures/<?= $bookedTour['photo_list'][0]?>" alt="tour-cover"/>
                        <div class="info-wrapper">
                            <div class="name-wrapper">
                                <div class="stars">
                                    <?php for ($i = 0; $i < $bookedTour['stars']; $i++) : ?>
                                        <span class="material-symbols-rounded">star</span>
                                    <?php endfor; ?>
                                </div>
                                <div class="name"><?= $bookedTour['name'] ?></div>
                                <div class="description"><?= $bookedTour['address'] ?></div>
                            </div>
                            <div class="rooms">
                                <?php foreach ($bookedRooms as $room) : ?>
                                    <div class="room">
                                        <span><?= $room['booked_count'] ?></span>
                                        <span class="material-symbols-rounded cross-icon">close</span>
                                        <span class="name"><?= $room['name'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </a>
                    <form method="post" action="" class="checkout-form menu-card"  class="booking">
                        <?php if (isset($userInfo)) : ?>
                            <h2>Дані заявки</h2>
                            <div class="user-info">
                                <div class="user-info-wrapper">
                                    <div class="label">Статус:</div>
                                    <div class="text status-wrapper">
                                        <?php if ($userInfo['status'] == 0) : ?>
                                            <span class="icon pending">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M280-420q25 0 42.5-17.5T340-480q0-25-17.5-42.5T280-540q-25 0-42.5 17.5T220-480q0 25 17.5 42.5T280-420Zm200 0q25 0 42.5-17.5T540-480q0-25-17.5-42.5T480-540q-25 0-42.5 17.5T420-480q0 25 17.5 42.5T480-420Zm200 0q25 0 42.5-17.5T740-480q0-25-17.5-42.5T680-540q-25 0-42.5 17.5T620-480q0 25 17.5 42.5T680-420ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                            </span>
                                            <span class="text">В обробці</span>
                                        <?php elseif ($userInfo['status'] == 1) : ?>
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
                                </div>
                                <div class="user-info-wrapper">
                                    <div class="label">Прізвище та ім'я:</div>
                                    <div class="text"><?= $userInfo['full_name'] ?></div>
                                </div>
                                <div class="user-info-wrapper">
                                    <div class="label">Номер телефону:</div>
                                    <div class="text"><?= $userInfo['phone_number'] ?></div>
                                </div>
                                <div class="user-info-wrapper">
                                    <div class="label">Профіль:</div>
                                    <div class="text user">
                                        <?php if (isset($userInfo['user'])) : ?>
                                            <a href="/user/view/<?= $userInfo['user']['username'] ?>" class="user">
                                                <div class="pfp" style="background: <?= $userInfo['user']['picture']['background'] ?>">
                                                    <span style="color: <?= $userInfo['user']['picture']['font_color'] ?>"><?= $userInfo['user']['picture']['letter'] ?></span>
                                                </div>
                                                <div class="user-name"><?= $userInfo['user']['username'] ?></div>
                                            </a>
                                        <?php else : ?>
                                            <div class="no-user">Без користувача</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (User::isCurrentUserModerator()) : ?>
                                <div class="row booking" data-booking-id="<?= $userInfo['booking_id'] ?>">
                                <?php if ($userInfo['status'] != 0) : ?>
                                    <button type="button" class="add-button simple-button change-status" id="room-facility-add-button" data-status="0">
                                        <span class="icon pending">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FF8C00"><path d="M280-420q25 0 42.5-17.5T340-480q0-25-17.5-42.5T280-540q-25 0-42.5 17.5T220-480q0 25 17.5 42.5T280-420Zm200 0q25 0 42.5-17.5T540-480q0-25-17.5-42.5T480-540q-25 0-42.5 17.5T420-480q0 25 17.5 42.5T480-420Zm200 0q25 0 42.5-17.5T740-480q0-25-17.5-42.5T680-540q-25 0-42.5 17.5T620-480q0 25 17.5 42.5T680-420ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                        </span>
                                        <span class="text">В обробку</span>
                                    </button>
                                <?php endif; ?>
                                <?php if ($userInfo['status'] != 1) : ?>
                                    <button type="button" class="add-button simple-button change-status" id="room-facility-add-button" data-status="1">
                                        <span class="icon check">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00A940"><path d="m424-408-86-86q-11-11-28-11t-28 11q-11 11-11 28t11 28l114 114q12 12 28 12t28-12l226-226q11-11 11-28t-11-28q-11-11-28-11t-28 11L424-408Zm56 328q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                        </span>
                                        <span class="text">Ухвалити</span>
                                    </button>
                                <?php endif; ?>
                                <?php if ($userInfo['status'] != 2) : ?>
                                    <button type="button" class="add-button simple-button change-status" id="room-facility-add-button" data-status="2">
                                        <span class="icon denial">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#db5858"><path d="m480-424 116 116q11 11 28 11t28-11q11-11 11-28t-11-28L536-480l116-116q11-11 11-28t-11-28q-11-11-28-11t-28 11L480-536 364-652q-11-11-28-11t-28 11q-11 11-11 28t11 28l116 116-116 116q-11 11-11 28t11 28q11 11 28 11t28-11l116-116Zm0 344q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                        </span>
                                        <span class="text">Відмовити</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <h2>Контактні дані</h2>
                            <div class="icon-input">
                                <input placeholder="Прізвище та ім'я" name="full_name" autocomplete="off">
                                <i class="material-symbols-rounded">id_card</i>
                            </div>
                            <div class="icon-input">
                                <input placeholder="Номер телефону" name="phone_number" autocomplete="off">
                                <i class="material-symbols-rounded">call</i>
                            </div>
                            <div class="description">Після заповнення форми ми розглянемо вашу заявку на протязі 3х днів. Ми зателефонуємо вам після з вказівками до наступних кроків</div>
                            <div>
                                <button class="accent-button">
                                    <span>Бронювати</span>
                                    <i class="material-icons">verified</i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="booking-details menu-card">
                    <h2>Деталі бронювання</h2>
                    <div class="line"></div>
                    <div class="booking-info">
                        <div class="grid-row">
                            <span class="bold">Дата в'їзду:</span>
                            <span class="text"><?= $bookingDetails['check_in'] ?></span>
                        </div>
                        <div class="grid-row">
                            <span class="bold">Дата виїзду:</span>
                            <span class="text"><?= $bookingDetails['check_out'] ?></span>
                        </div>
                        <div class="grid-row">
                            <span class="bold">К-сть людей:</span>
                            <span class="text"><?= $bookingDetails['tourists'] ?></span>
                        </div>
                        <div class="description">Можливо скасувати до <?= $bookingDetails['cancel_before_date'] ?></div>
                    </div>
                    <div class="line"></div>
                    <div class="price-info">
                        <?php foreach ($bookedRooms as $room) : ?>
                            <div class="grid-row">
                                <span class="name"><?= $room['name'] ?></span>
                                <span class="material-symbols-rounded icon">close</span>
                                <span><?= $room['booked_count'] ?></span>
                                <span class="material-symbols-rounded icon">equal</span>
                                <span class="cost"><?= $room['cost'] ?></span>
                            </div>
                            <div class="description">Ціна кімнати на 1 день: <?= $room['str_price'] ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="line"></div>
                    <div class="total-price">
                        <div class="total-price-wrapper">
                            <div class="text">Разом:</div>
                            <div class="price"><?= $bookingDetails['total_price'] ?></div>
                        </div>
                        <div class="description">Загальна ціна за всіх людей</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>

<?php include 'views/components/popup/popup.php'?>

<script>
    <?php include 'views/components/header/header_script.js'?>
    <?php include 'views/components/popup/popup_script.js'?>
    <?php include 'checkout_script.js'?>
    <?php include 'views/admin/booking_admin/change_status_script.js' ?>
</script>
</body>
</html>