<?php

use models\User;
/** @var array $tour */

/** @var array $searchParams */

?>

<div class="booking" data-tour-id="<?= $tour['tour_id'] ?>">
    <h2>Бронювання номера</h2>
    <div class="small-search-bar search-bar" id="search-bar">
        <?php include 'views/tours/search_bar/date_picker/date_picker.php'?>
        <?php include 'views/tours/search_bar/number_input/days_input.php'?>
        <?php include 'views/tours/search_bar/number_input/tourists_input.php'?>
        <div class="search-button">
            <button class="accent-button">
                <span>Змінити</span>
                <i class="material-icons">refresh</i>
            </button>
        </div>
    </div>
    <div id="rooms" class="description" style="color: gray" >Підберіть оптимальний варіант для ваших параметрів</div>
    <div class="rooms-table" >
        <table>
            <thead>
            <tr>
                <td colspan="6"><div class="theader">Доступні номери</div></td>
            </tr>
            <tr>
                <td><div>Назва номера</div></td>
                <td><div>Фотографії</div></td>
                <td><div>Місткість</div></td>
                <td><div>Зручності</div></td>
                <td><div>Ціна за <?= \core\Utils::formatedDays($searchParams['days']) ?></div></td>
                <td><div>Забронювати</div></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tour['rooms'] as $room) : ?>
                <tr class="<?= $room['left'] < 1 ? 'unavailable' : '' ?>">
                <td class="name-field">
                    <div>
                        <div class="name"><?= $room['name'] ?></div>
                        <div class="description"><?= $room['description'] ?></div>
                        <?php if ($room['left'] < 1) : ?>
                            <div class="unavailable-text">
                                Unavailable
                            </div>
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <div>
                        <button class="open-slider">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#1E1F22"><path d="m530-460-46-60q-6-8-16-8t-16 8l-67 88q-8 10-2.5 21t18.5 11h318q13 0 18.5-11t-2.5-21l-97-127q-6-8-16-8t-16 8l-76 99ZM320-240q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-520q0-17 11.5-28.5T120-720q17 0 28.5 11.5T160-680v520h520q17 0 28.5 11.5T720-120q0 17-11.5 28.5T680-80H160Zm160-720v480-480Z"/></svg>
                            </span>
                            <span class="images" style="display: none">
                                <?php foreach ($room['photo_list'] as $photo) : ?>
                                    <img src="/files/tours/rooms/<?= $photo ?>" alt="room" />
                                <?php endforeach; ?>
                            </span>
                        </button>
                    </div>
                </td>
                <td>
                    <div>
                        <div class="capacity">
                            <span class="text"><?= $room['capacity'] ?></span>
                            <span class="material-symbols-rounded cross-icon">close</span>
                            <span class="material-symbols-rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
                            </span>
                        </div>
                    </div>
                </td>
                <td>
                    <div>
                        <div class="room-facilities">
                            <?php foreach ($room['facilities_list'] as $facility) : ?>
                                <div class="facility">
                                    <span class="icon-wrapper">
                                        <img src="/files/facilities/<?= $facility['icon'] ?>" alt="view">
                                    </span>
                                    <span class="text"><?= $facility['name'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div>
                        <div class="price" data-price="<?= $room['price'] * $searchParams['days'] ?>"><?= \core\Utils::formatedPrice($room['price'] * $searchParams['days']) ?></div>
                        <div class="description">За <?= \core\Utils::formatedTourists($room['capacity']) ?></div>
                    </div>
                </td>
                <td>
                    <div>
                        <div class="search-bar room-select-wrapper">
                            <div class="country-select select" data-selected-id="0" data-room-id="<?= $room['room_id'] ?>">
                                <button class="search-bar-header">
                                    <i class="material-icons">bed</i>
                                    <span class="text">0 кімнат</span>
                                    <div class="arrow-wrapper">
                                        <i class="material-icons">chevron_right</i>
                                    </div>
                                </button>
                                <div class="drop-down  hide">
                                    <div class="drop-menu">
                                        <div class="options drop-down-scroll-bar">
                                            <?php for ($i = 0; $i <= min($room['left'], 10); $i++) : ?>
                                                <button class="option" data-option-id="<?= $i ?>" data-option-name="<?= \core\Utils::shortFormatedRooms($i) ?>">
                                                    <span class="arrow">
                                                        <i class="material-icons">chevron_right</i>
                                                    </span>
                                                        <span class="actual-option">
                                                        <span class="rooms-count">
                                                            <?= \core\Utils::shortFormatedRooms($i) ?>
                                                        </span>
                                                        <span class="rooms-price">
                                                            <?= \core\Utils::formatedPrice($room['price'] * $i) ?>
                                                        </span>
                                                    </span>
                                                </button>
                                                <div class="line"></div>
                                            <?php endfor; ?>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="description"><?= \core\Utils::formatedRooms($room['left']) ?></div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <div class="total-count">
                            <div class="description">Обрані кімнати</div>
                            <div class="rooms">

                            </div>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="total-capacity">
                            <div class="description">Кількість місць</div>
                            <div class="capacity">
                                <span class="text">0</span>
                                <span class="material-symbols-rounded cross-icon">close</span>
                                <span class="material-symbols-rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="total-price" data-days="<?= $searchParams['days'] ?>">
                            <div class="left">
                                <div class="description">Загальна ціна за <?= \core\Utils::formatedDays($searchParams['days']) ?></div>
                                <div class="price"><?= \core\Utils::formatedPrice(0) ?></div>
                            </div>
                            <div>
                                <button class="accent-button checkout">
                                    <span>Забронювати</span>
                                    <i class="material-icons">verified</i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>