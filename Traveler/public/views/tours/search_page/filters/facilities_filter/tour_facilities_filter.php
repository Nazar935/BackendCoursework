<?php

use models\User;

/** @var array $tourFacilities */

?>

<div class="facilities-filter filter">
    <h3 class="filter-header">Зручності в готелі</h3>
    <div class="filter-body facilities-select" id="tour-facilities">
        <?php foreach ($tourFacilities as $i => $facility) : ?>
            <label for="room-facility-<?= $i ?>" data-facility-id="<?= $facility['facility_id'] ?>" class="check">
                <span class="check-box">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Z"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h499q17 0 28.5 11.5T739-800q0 17-11.5 28.5T699-760H200v560h560v-260q0-17 11.5-28.5T800-500q17 0 28.5 11.5T840-460v260q0 33-23.5 56.5T760-120H200Zm261-272 340-340q11-11 27-11t28 11q12 11 12 28t-12 29L489-308q-12 12-28 12t-28-12L263-478q-11-11-11-28t11-28q11-11 28-11t28 11l142 142Z"/></svg>
                </span>
                <span class="icon">
                    <img src="/files/facilities/<?= $facility['icon'] ?>" alt="facility-icon"/>
                </span>
                <span class="text"><?= $facility['name']?></span>
                <input id="room-facility-<?= $i ?>" type="checkbox" style="display: none"/>
            </label>
        <?php endforeach; ?>
    </div>
    <button class="clear">Очистити</button>
</div>