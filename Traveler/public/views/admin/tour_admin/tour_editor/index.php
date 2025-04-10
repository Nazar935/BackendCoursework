<?php

use models\User;

/** @var array $tour */
/** @var array $countryArray */
/** @var array $tourFacilities */
/** @var array $roomFacilities */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/favicon.ico">

    <title>Traveler - Admin</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'tour_editor_style.css'?>
        <?php include 'views/tours/view/booking/booking_styles.css'?>
        <?php include 'views/tours/search_page/filters/star_filter/star_filter_styles.css'?>
        <?php include 'views/tours/search_page/filters/facilities_filter/facilities_select_styles.css'?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main class="tour-editor">
        <h1 class="cool-header">
            <span class="header-text">
                <?php if (isset($tour)) : ?>
                    Змінити дані про <span class="underline">тур</span>
                <?php else: ?>
                    Додати новий <span class="underline">тур</span>
                <?php endif; ?>
            </span>
        </h1>
        <form  action="<?= !isset($tour) ? "/tours/add" : "/tours/edit/" . $tour['link'] ?>" class="country-form" method="POST" enctype="multipart/form-data">

            <div class="grid">
                <div class="left">
                    <?php if (isset($tour)) : ?>
                        <input name="tour_id" value="<?= $tour['tour_id'] ?>" style="display: none"/>
                    <?php endif; ?>
                    <div class="row">
                        <div class="name-input text-input-wrapper input-wrapper">
                            <div class="input-name">Назва:</div>
                            <div class="icon-input">
                                <input name="name" type="text" value="<?= !isset($tour) ? "" : $tour['name'] ?>">
                            </div>
                        </div>
                        <div class="link-input text-input-wrapper input-wrapper">
                            <div class="input-name">Посилання:</div>
                            <div class="icon-input">
                                <input name="link" type="text" value="<?= !isset($tour) ? "" : $tour['link'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-wrapper star-input">
                            <div class="input-name">Категорія:</div>
                            <div class="stars-select" id="star-select">
                                <input name="stars" type="number" style="display: none"  value="<?= !isset($tour) ? "" : $tour['stars'] ?>"/>
                                <button type="button" class="disabled" disabled>
                <span class="star">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z"/></svg>
                </span>
                                </button>
                                <button type="button" >
                            <span class="star">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z"/></svg>
                            </span>
                                </button>
                                <button type="button" >
                            <span class="star">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z"/></svg>
                            </span>
                                </button>
                                <button type="button" >
                            <span class="star">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z"/></svg>
                            </span>
                                </button>
                                <button type="button" >
                            <span class="star">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143Zm126 18L314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Zm0-201Z"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-269 314-169q-11 7-23 6t-21-8q-9-7-14-17.5t-2-23.5l44-189-147-127q-10-9-12.5-20.5T140-571q4-11 12-18t22-9l194-17 75-178q5-12 15.5-18t21.5-6q11 0 21.5 6t15.5 18l75 178 194 17q14 2 22 9t12 18q4 11 1.5 22.5T809-528L662-401l44 189q3 13-2 23.5T690-171q-9 7-21 8t-23-6L480-269Z"/></svg>
                            </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-wrapper">
                            <div class="input-name">Країна</div>
                            <div class="country-input">
                                <select name="country" id="country_select">
                                    <?php foreach ($countryArray as $country) : ?>
                                        <option value="<?= $country['country_id']?>"
                                            <?php if (isset($tour) && $tour['country_id'] == $country['country_id']) : ?>
                                                selected="selected"
                                            <?php endif; ?>
                                        ><?= $country['ua_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-wrapper">
                            <div class="input-name">Місто</div>
                            <div class="city-input">
                                <?php foreach ($countryArray as $country) : ?>
                                    <select class="city-select hide" name="city" data-country-id="<?= $country['country_id']?>" disabled>
                                        <?php foreach ($country['cities'] as $city) : ?>
                                            <option value="<?= $city['city_id']?>"
                                                <?php if (isset($tour) && $tour['city_id'] == $city['city_id']) : ?>
                                                    selected="selected"
                                                <?php endif; ?>
                                            ><?= $city['name']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="photo-list-input">
                        <input name="photo_list[]" type="file" multiple>
                    </div>
                    <div class="description-input">
                        <div class="text-input-wrapper input-wrapper">
                            <div class="input-name">Опис:</div>
                            <div class="icon-input">
                                <textarea name="description" ><?= !isset($tour) ? "" : $tour['description'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="address">
                        <div class="text-input-wrapper input-wrapper">
                            <div class="input-name">Адреса:</div>
                            <div class="icon-input">
                                <input name="address" type="text" value="<?= !isset($tour) ? "" : $tour['address'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="coordinates-input">
                        <div class="text-input-wrapper input-wrapper">
                            <div class="input-name">Координати:</div>
                            <div class="icon-input">
                                <div class="coordinate-y">
                                    X:
                                    <input name="coordinate_x" value="<?= !isset($tour) ? "" : $tour['location_longitude'] ?>"/>
                                </div>
                                <div class="coordinate-y">
                                    Y:
                                    <input name="coordinate_y" value="<?= !isset($tour) ? "" : $tour['location_latitude'] ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="google-maps-link">
                        <div class="text-input-wrapper input-wrapper">
                            <div class="input-name">Посилання на Google Maps:</div>
                            <div class="icon-input">
                                <input name="google_maps_link" type="text" value="<?= !isset($tour) ? "" : $tour['google_maps_link'] ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="input-wrapper">
                        <div class="input-name">Зручності в готелі:</div>
                        <div class="facilities-select" id="tour-facilities">
                            <?php foreach ($tourFacilities as $i => $facility) : ?>
                                <label for="tour-facility-<?= $facility['facility_id'] ?>" data-facility-id="<?= $facility['facility_id'] ?>" class="check">
                                    <span class="check-box">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h499q17 0 28.5 11.5T739-800q0 17-11.5 28.5T699-760H200v560h560v-260q0-17 11.5-28.5T800-500q17 0 28.5 11.5T840-460v260q0 33-23.5 56.5T760-120H200Zm261-272 340-340q11-11 27-11t28 11q12 11 12 28t-12 29L489-308q-12 12-28 12t-28-12L263-478q-11-11-11-28t11-28q11-11 28-11t28 11l142 142Z"/></svg>
                                    </span>
                                                        <span class="icon">
                                        <img src="/files/facilities/<?= $facility['icon'] ?>" alt="facility-icon"/>
                                    </span>
                                    <span class="text"><?= $facility['name']?></span>
                                    <input id="tour-facility-<?= $facility['facility_id'] ?>" name="tour_facilities[]" value="<?= $facility['facility_id'] ?>" type="checkbox" type="checkbox" style="display: none"
                                        <?php
                                            if (isset($tour))
                                                foreach ($tour['facilities'] as $tourFacility)
                                                    if ($facility['facility_id'] == $tourFacility['facility_id']) {
                                                        echo "checked";
                                                        break;
                                                    }
                                        ?>
                                    />
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!--<div class="tour-facilities">
                        <?php /*if (!isset($tour)) : */?>
                            <?php /*foreach ($tourFacilities as $facility) : */?>
                                <label >
                                    <input id="tour-facility-<?php /*= $facility['facility_id'] */?>" name="tour_facilities[]" value="<?php /*= $facility['facility_id'] */?>" type="checkbox" />
                                    <?php /*= $facility['name']*/?>
                                </label>

                            <?php /*endforeach; */?>
                        <?php /*else : */?>
                            <?php /*foreach ($tourFacilities as $facility) : */?>
                                <label >
                                    <input id="tour-facility-<?php /*= $facility['facility_id'] */?>" name="tour_facilities[]" value="<?php /*= $facility['facility_id'] */?>" type="checkbox"
                                        <?php
/*                                        foreach ($tour['facilities'] as $tourFacility)
                                            if ($facility['facility_id'] == $tourFacility['facility_id']) {
                                                echo "checked";
                                                break;
                                            }
                                        */?>
                                    />
                                    <?php /*= $facility['name']*/?>
                                </label>

                            <?php /*endforeach; */?>
                        <?php /*endif; */?>
                    </div>-->
                </div>
            </div>
            <div class="rooms">
                <div class="rooms-table" id="rooms-table">
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
                                <td><div>Ціна за 1 ніч</div></td>
                                <td><div>Кількість</div></td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (isset($tour)) : ?>
                                <?php foreach ($tour['rooms'] as $roomIndex => $room) : ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <input name="room_id[<?= $roomIndex ?>]" value="<?= $room['room_id'] ?>" style="display: none"/>
                                                <div class="name">
                                                    <input name="room_name[<?= $roomIndex ?>]" value="<?= $room['name'] ?>">
                                                </div>
                                                <div class="description">
                                                    <textarea name="room_description[<?= $roomIndex ?>]"><?= $room['description'] ?></textarea>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input name="room_photo_list[<?= $roomIndex ?>][]" type="file" multiple>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="capacity">
                                            <span>
                                                <input name="room_capacity[<?= $roomIndex ?>]" type="number" value="<?= $room['capacity'] ?>">
                                            </span>
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
                                                    <?php foreach ($roomFacilities as $facility) : ?>
                                                        <div class="facility" data-facility-id="<?= $facility['facility_id']?>">
                                                            <label >
                                                                <input name="room_facilities[<?= $roomIndex ?>][]" value="<?= $facility['facility_id']?>" type="checkbox"
                                                                    <?php
                                                                    foreach ($room['facilities'] as $roomFacility)
                                                                        if ($facility['facility_id'] == $roomFacility['facility_id']) {
                                                                            echo "checked";
                                                                            break;
                                                                        }
                                                                    ?>
                                                                />
                                                                <span class="icon-wrapper">
                                                            <img src="/files/static/facilities/<?= $facility['icon']?>" alt="<?= $facility['icon']?>">
                                                        </span>
                                                                <span class="text"><?= $facility['name']?></span>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="price">
                                                    UAH
                                                    <input name="room_price[<?= $roomIndex ?>]" type="text"  value="<?= $room['price'] ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="count-td">
                                            <div class="count">
                                                Кількість кімнат:
                                                <input name="room_count[<?= $roomIndex ?>]" type="number"  value="<?= $room['count'] ?>"/>
                                            </div>
                                            <div class="edit">
                                                <button type="button" class="room-delete-button">Del</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <div>
                                    <button  type="button" id="add-room-button" class="simple-button">
                                        <span class="icon">
                                            <i class="material-icons">post_add</i>
                                        </span>
                                        <span class="text">Додати кімнату</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div>
                <button class="simple-button">
                    <?php if (!isset($tour)) : ?>
                        <span class="icon">
                            <i class="material-icons">post_add</i>
                        </span>
                        <span class="text">Додати тур</span>
                    <?php else: ?>
                        <span class="icon">
                            <i class="material-icons">post_add</i>
                        </span>
                        <span class="text">Змінити тур</span>
                    <?php endif; ?>
                </button>
            </div>
        </form>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>


<script>
    <?php include 'views/components/header/header_script.js' ?>
    <?php include 'views/tours/search_page/filters/star_filter/star_select_script.js'?>
    <?php include 'views/tours/search_page/filters/facilities_filter/facilities_select_script.js'?>
    <?php include 'tour_editor_script.js'?>
    <?php include 'location_select.js'?>
</script>
</body>
</html>