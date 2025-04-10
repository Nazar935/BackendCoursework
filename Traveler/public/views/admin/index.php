<?php

use models\User;

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
        <?php include 'admin_style.css'?>
        <?php include 'country_admin/country_admin_style.css'?>
        <?php include 'facilities_admin/facilities_styles.css'?>
        <?php include 'views/components/popup/popup_styles.css'?>
        <?php include 'country_admin/country_editor/file_input_styles.css'?>
        <?php include 'tour_admin/tour_admin_style.css'?>
        <?php include 'booking_admin/booking_admin_styles.css'?>
        <?php include 'user_admin/user_admin_styles.css'?>
        <?php include 'booking_admin/booking_list_styles.css'?>
        <?php include 'views/user/login/form_error_style.css'?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main class="admin-page">
        <h1 class="cool-header">
            <span class="header-text">
                Панель <span class="underline">адміністратора</span>
            </span>
        </h1>
        <div class="admin">
            <div class="row">
                <div class="left">
                    <div class="tour-admin-wrapper">
                        <?php include 'tour_admin/tour_admin.php'?>
                    </div>
                    <div class="user-admin-wrapper">
                        <?php include 'user_admin/user_admin.php'?>
                    </div>
                </div>
                <div class="right">
                    <div class="booking-admin-wrapper">
                        <?php include 'booking_admin/booking_admin.php'?>
                    </div>
                    <div class="reviews-admin-wrapper page-admin">
                        <h2>Відгуки</h2>
                        <a href="/reviews/admin" class="simple-button" id="country-add-button">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M240-160q-33 0-56.5-23.5T160-240q0-33 23.5-56.5T240-320q33 0 56.5 23.5T320-240q0 33-23.5 56.5T240-160Zm0-240q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm0-240q-33 0-56.5-23.5T160-720q0-33 23.5-56.5T240-800q33 0 56.5 23.5T320-720q0 33-23.5 56.5T240-640Zm240 0q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Zm240 0q-33 0-56.5-23.5T640-720q0-33 23.5-56.5T720-800q33 0 56.5 23.5T800-720q0 33-23.5 56.5T720-640ZM480-400q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm40 200v-66q0-8 3-15.5t9-13.5l209-208q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L655-172q-6 6-13.5 9t-15.5 3h-66q-17 0-28.5-11.5T520-200Zm300-223-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                            </span>
                            <span class="text">Редагувати сторінку</span>
                        </a>
                    </div>
                    <div class="faq-admin-wrapper page-admin">
                        <h2>Запитання та відповіді</h2>
                        <a href="/faq/admin" class="simple-button" id="country-add-button">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M240-160q-33 0-56.5-23.5T160-240q0-33 23.5-56.5T240-320q33 0 56.5 23.5T320-240q0 33-23.5 56.5T240-160Zm0-240q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm0-240q-33 0-56.5-23.5T160-720q0-33 23.5-56.5T240-800q33 0 56.5 23.5T320-720q0 33-23.5 56.5T240-640Zm240 0q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Zm240 0q-33 0-56.5-23.5T640-720q0-33 23.5-56.5T720-800q33 0 56.5 23.5T800-720q0 33-23.5 56.5T720-640ZM480-400q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm40 200v-66q0-8 3-15.5t9-13.5l209-208q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L655-172q-6 6-13.5 9t-15.5 3h-66q-17 0-28.5-11.5T520-200Zm300-223-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                            </span>
                            <span class="text">Редагувати сторінку</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="country-admin-wrapper">
                    <?php include 'country_admin/country_admin.php'?>
                </div>
                <div class="tour-facilities-wrapper">
                    <?php include 'facilities_admin/tour_facilities.php'?>
                </div>
                <div class="room-facilities-wrapper">
                    <?php include 'facilities_admin/room_facilities.php'?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>

<?php include 'views/components/popup/popup.php'?>

<script>
    <?php include 'views/components/header/header_script.js'?>
    <?php include 'country_admin/country_admin_script.js'?>
    <?php include 'facilities_admin/facilities_script.js'?>
    <?php include 'views/components/popup/popup_script.js'?>
    <?php include 'country_admin/country_editor/file_input_script.js'?>
    <?php include 'tour_admin/tour_admin_script.js'?>
    <?php include 'booking_admin/booking_list_script.js'?>
    <?php include 'user_admin/user_admin_script.js'?>
    <?php include 'views/user/login/form_error_script.js'?>
    <?php include 'booking_admin/change_status_script.js'?>
</script>
</body>
</html>