<?php

/** @var array $searchParams */

?>

<div class="days-input number-select" data-name="days"
    <?= array_key_exists("days", $searchParams)? "data-search=" . $searchParams['days'] : ""?>
>
    <button class="search-bar-header">
        <i class="material-icons">schedule</i>
        <span class="text">Дні</span>
        <div class="arrow-wrapper">
            <i class="material-icons">chevron_right</i>
        </div>
    </button>

    <div class="number-picker drop-down hide">
        <div class="drop-menu">
            <div class="number-input">
                <div class="button-wrapper">
                    <button class="minus-button">
                        <i class="material-icons">remove</i>
                    </button>
                </div>
                <div class="input-wrapper">
                    <input type="number" value="3" min="1" max="31">
                </div>
                <div class="button-wrapper">
                    <button class="plus-button">
                        <i class="material-icons">add</i>
                    </button>
                </div>
                <div class="line"></div>
                <div class="button-wrapper">
                    <button class="select-button">
                        <i class="material-icons">arrow_forward</i>
                    </button>
                </div>
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