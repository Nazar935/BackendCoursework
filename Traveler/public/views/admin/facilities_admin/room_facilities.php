<?php

/** @var array $roomFacilities */

?>

<div class="facilities-admin">
    <h2>Зручності кімнат</h2>
    <div class="line"></div>
    <div class="facilities">
        <?php foreach ($roomFacilities as $i => $facility) : ?>
            <div class="facility room-facility"
                 data-id="<?= $facility['facility_id']?>"
                 data-name="<?= $facility['name']?>"
                 data-icon-path="<?= $facility['icon']?>"
            >
                <div class="index">
                    <?= $i + 1 ?>.
                </div>
                <div class="icon">
                    <img src="/files/facilities/<?= $facility['icon']?>" alt="icon"/>
                </div>
                <div class="name">
                    <?= $facility['name']?>
                </div>
                <div class="buttons">
                    <button class="edit-button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-200h57l391-391-57-57-391 391v57Zm-40 80q-17 0-28.5-11.5T120-160v-97q0-16 6-30.5t17-25.5l505-504q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L313-143q-11 11-25.5 17t-30.5 6h-97Zm600-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                    </button>
                    <button class="delete-button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM400-280q17 0 28.5-11.5T440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280Zm160 0q17 0 28.5-11.5T600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280ZM280-720v520-520Z"/></svg>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="line"></div>
    <button class="add-button simple-button" id="room-facility-add-button">
            <span class="icon">
                <i class="material-icons">post_add</i>
            </span>
        <span class="text">Додати зручність</span>
    </button>
</div>