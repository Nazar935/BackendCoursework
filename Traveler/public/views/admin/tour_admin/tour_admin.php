<?php

/** @var array $toursArray */

?>

<div class="tour-admin">
    <h2>Тури</h2>
    <div class="tour-search search">
        <input id="tour-search" class="simple-input" type="text" placeholder="Пошук">
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
        </span>
    </div>
    <div class="line"></div>
    <div class="tours-list" id="tours-list">
        <?php /*foreach ($toursArray as $index => $tour) : */?><!--
            <div class="tour" data-tour-id="<?php /*= $tour['tour_id'] */?>">
                <div class="index">
                    <?php /*= $index + 1 */?>.
                </div>
                <a href="/tours/view/<?php /*= $tour['link'] */?>" class="link">
                    <div class="picture">
                        <img src="/files/tours/pictures/<?php /*= $tour['photo_list'][0]*/?>" alt="tour-picture"/>
                    </div>
                    <div class="name">
                        <div class="stars">
                            <?php /*for ($i = 0; $i < $tour['stars']; $i++) : */?>
                                <span class="material-symbols-rounded">star</span>
                            <?php /*endfor; */?>
                        </div>
                        <div class="text">
                            <?php /*= $tour['name'] */?>
                        </div>
                        <div class="description">
                            <?php /*= $tour['country']['ua_name']*/?>,
                            <?php /*= $tour['city']['name']*/?>
                        </div>
                    </div>
                </a>
                <div class="buttons">
                    <a href="/tours/edit/<?php /*= $tour['link'] */?>" class="edit-button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M200-200h57l391-391-57-57-391 391v57Zm-40 80q-17 0-28.5-11.5T120-160v-97q0-16 6-30.5t17-25.5l505-504q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L313-143q-11 11-25.5 17t-30.5 6h-97Zm600-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                    </a>
                    <button class="delete-button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM400-280q17 0 28.5-11.5T440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280Zm160 0q17 0 28.5-11.5T600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280ZM280-720v520-520Z"/></svg>
                    </button>
                </div>
            </div>
        --><?php /*endforeach; */?>
    </div>
    <div class="line"></div>
    <a href="/tours/add" class="add-button simple-button" id="tour-add-button">
            <span class="icon">
                <i class="material-icons">post_add</i>
            </span>
        <span class="text">Додати тур</span>
    </a>
</div>