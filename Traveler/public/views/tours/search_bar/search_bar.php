<?php

/** @var array $searchParams */

?>

<div class="search-bar" id="search-bar">
    <?php include 'select_input/country_select.php'?>
    <?php include 'select_input/city_select.php'?>
    <?php include 'date_picker/date_picker.php'?>
    <?php include 'number_input/days_input.php'?>
    <?php include 'number_input/tourists_input.php'?>

    <div class="search-button">
        <button class="accent-button">
            <span>Пошук</span>
            <i class="material-icons">search</i>
        </button>
    </div>
</div>