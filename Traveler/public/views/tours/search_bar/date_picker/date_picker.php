<?php

/** @var array $searchParams */

?>


<div class="date-input" data-name="date"
    <?= array_key_exists("date", $searchParams)? "data-search=" . $searchParams['date'] : ""?>
>
    <button class="search-bar-header">
        <i class="material-icons">calendar_month</i>
        <span class="text">Дата</span>
        <div class="arrow-wrapper">
            <i class="material-icons">chevron_right</i>
        </div>
    </button>
    <div class="date-picker drop-down hide">
        <div class="drop-menu">
            <div class="top-panel" id="date-table-header">
                <div class="button-wrapper">
                    <button class="previous-month">
                        <i class="material-icons">chevron_right</i>
                    </button>
                </div>
                <div class="current-month">
                <span class="month animation-wrapper">
                    <span class="animation"></span>
                    <span class="current">Березень</span>
                </span>
                    <span class="year animation-wrapper">
                    <span class="animation"></span>
                    <span class="current">2025</span>
                    <span style="letter-spacing: -1px">р.</span>
                </span>
                </div>
                <div class="button-wrapper">
                    <button class="next-month">
                        <i class="material-icons">chevron_right</i>
                    </button>
                </div>
            </div>
            <div class="date-panel">
                <table class="table-header">
                    <thead>
                    <tr>
                        <td>Пн</td>
                        <td>Вт</td>
                        <td>Ср</td>
                        <td>Чт</td>
                        <td>Пт</td>
                        <td>Сб</td>
                        <td>Вс</td>
                    </tr>
                    </thead>
                </table>
                <table class="date-table">
                    <tbody id="date-table-body">
                    <tr>
                        <td>
                            <button class="disabled" disabled="">24</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">25</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">26</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">27</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">28</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">1</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">2</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">3</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">4</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">5</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">6</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">7</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">8</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">9</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">10</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">11</button>
                        </td>
                        <td>
                            <button class="disabled this-month" onclick="datePick(this)" disabled="">12</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">13</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">14</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">15</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">16</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="this-month" onclick="datePick(this)">17</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">18</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">19</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">20</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">21</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">22</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">23</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="this-month" onclick="datePick(this)">24</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">25</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">26</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">27</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">28</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">29</button>
                        </td>
                        <td>
                            <button class="this-month" onclick="datePick(this)">30</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="this-month" onclick="datePick(this)">31</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">1</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">2</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">3</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">4</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">5</button>
                        </td>
                        <td>
                            <button class="disabled" disabled="">6</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
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