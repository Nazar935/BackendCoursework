<?php

use models\User;

/** @var $header_page */

$message = null;
if (isset($_SESSION['message']))
{
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

?>

<header class="header">
    <div class="header-wrapper">
        <div class="logo">
            <a href="/home">
                <div class="plane-wrapper">
                    <div class="plane-trail"></div>
                    <div class="plane">
                        <div class="planeBody">
                            <div class="planeTail"></div>
                            <div class="wingLeft"></div>
                            <div class="wingRight"></div>
                        </div>
                    </div>
                </div>
                <div class="main-logo">
                    <span class="text">Traveler</span>
                    <span class="icon">🌎</span>
                </div>
            </a>
        </div>
        <div class="dashed-line"></div>
        <div class="main-menu">
            <div class="header-a-wrapper">
                <a href="/tours" class="header-a <?= $header_page == 'tours'? 'current-page' : ''?>">
            <span class="icon">
                <i class="material-icons">airplane_ticket</i>
            </span>
                    <span class="text">Тури</span>
                </a>
            </div>
            <div class="header-a-wrapper">
                <a href="/reviews" class="header-a <?= $header_page == 'reviews'? 'current-page' : ''?>">
            <span class="icon">
                <i class="material-icons">history_edu</i>
            </span>
                    <span class="text">Відгуки</span>
                </a>
            </div>
            <div class="header-a-wrapper">
                <a href="/faq" class="header-a <?= $header_page == 'faq'? 'current-page' : ''?>">
            <span class="icon">
                <i class="material-icons">quiz</i>
            </span>
                    <span class="text">Питання</span>
                </a>
            </div>
            <div class="header-a-wrapper">
                <a href="/contacts" class="header-a <?= $header_page == 'contacts'? 'current-page' : ''?>">
            <span class="icon">
                <i class="material-icons">support_agent</i>
            </span>
                    <span class="text">Контакти</span>
                </a>
            </div>

        </div>
        <?php if (User::isCurrentUserModerator()) : ?>
            <div class="dashed-line"></div>
            <div class="admin-menu">
                <a href="/admin" class="header-a  <?= $header_page == 'admin'? 'current-page' : ''?>">
                <span class="icon">
                    <i class="material-icons">settings</i>
                </span>
                    <span class="text">Адмін</span>
                </a>
            </div>
        <?php endif; ?>
        <div class="dashed-line"></div>
        <div class="user-menu">
            <!--<div class="theme-toggle">
                <svg display="none">
                    <symbol id="light" viewBox="0 0 24 24">
                        <g stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(0,12,12)" />
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(45,12,12)" />
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(90,12,12)" />
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(135,12,12)" />
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(180,12,12)" />
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(225,12,12)" />
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(270,12,12)" />
                            <line x1="12" y1="17" x2="12" y2="20" transform="rotate(315,12,12)" />
                        </g>
                        <circle fill="currentColor" cx="12" cy="12" r="5" />
                    </symbol>
                    <symbol id="dark" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M15.1,14.9c-3-0.5-5.5-3-6-6C8.8,7.1,9.1,5.4,9.9,4c0.4-0.8-0.4-1.7-1.2-1.4C4.6,4,1.8,7.9,2,12.5c0.2,5.1,4.4,9.3,9.5,9.5c4.5,0.2,8.5-2.6,9.9-6.6c0.3-0.8-0.6-1.7-1.4-1.2C18.6,14.9,16.9,15.2,15.1,14.9z" />
                    </symbol>
                </svg>
                <label class="switch">
                    <input class="switch__input" type="checkbox" role="switch" name="dark" />
                    <svg class="switch__icon" width="24px" height="24px" aria-hidden="true">
                        <use href="#light" />
                    </svg>
                    <svg class="switch__icon" width="24px" height="24px" aria-hidden="true">
                        <use href="#dark" />
                    </svg>
                    <span class="switch__inner"></span>
                    <span class="switch__inner-icons">
            <svg class="switch__icon" width="24px" height="24px" aria-hidden="true">
                <use href="#light" />
            </svg>
            <svg class="switch__icon" width="24px" height="24px" aria-hidden="true">
                <use href="#dark" />
            </svg>
        </span>
                    <span class="switch__sr">Dark Mode</span>
                </label>
            </div>-->

            <?php if (!User::isLogUser()) : ?>
                <a href="/user/login" class="header-a  <?= $header_page == 'user'? 'current-page' : ''?>">
                <span class="icon">
                    <i class="material-icons">login</i>
                </span>
                    <span class="text">Увійти</span>
                </a>
            <?php else : ?>
                <a href="/user/" class="header-a  <?= $header_page == 'user'? 'current-page' : ''?>">
                <span class="icon">
                    <i class="material-icons">account_circle</i>
                </span>
                    <span class="text">Профіль</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="message-wrapper" id="message">
        <div class="message">
            <div class="icon">
                <svg class="neutral" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m438-452-58-57q-11-11-27.5-11T324-508q-11 11-11 28t11 28l86 86q12 12 28 12t28-12l170-170q12-12 11.5-28T636-592q-12-12-28.5-12.5T579-593L438-452ZM326-90l-58-98-110-24q-15-3-24-15.5t-7-27.5l11-113-75-86q-10-11-10-26t10-26l75-86-11-113q-2-15 7-27.5t24-15.5l110-24 58-98q8-13 22-17.5t28 1.5l104 44 104-44q14-6 28-1.5t22 17.5l58 98 110 24q15 3 24 15.5t7 27.5l-11 113 75 86q10 11 10 26t-10 26l-75 86 11 113q2 15-7 27.5T802-212l-110 24-58 98q-8 13-22 17.5T584-74l-104-44-104 44q-14 6-28 1.5T326-90Zm52-72 102-44 104 44 56-96 110-26-10-112 74-84-74-86 10-112-110-24-58-96-102 44-104-44-56 96-110 24 10 112-74 86 74 84-10 114 110 24 58 96Zm102-318Z"/></svg>
                <svg class="negative" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm0-160q17 0 28.5-11.5T520-480v-160q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640v160q0 17 11.5 28.5T480-440ZM363-120q-16 0-30.5-6T307-143L143-307q-11-11-17-25.5t-6-30.5v-234q0-16 6-30.5t17-25.5l164-164q11-11 25.5-17t30.5-6h234q16 0 30.5 6t25.5 17l164 164q11 11 17 25.5t6 30.5v234q0 16-6 30.5T817-307L653-143q-11 11-25.5 17t-30.5 6H363Zm1-80h232l164-164v-232L596-760H364L200-596v232l164 164Zm116-280Z"/></svg>
                <svg class="positive" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="m438-452-58-57q-11-11-27.5-11T324-508q-11 11-11 28t11 28l86 86q12 12 28 12t28-12l170-170q12-12 11.5-28T636-592q-12-12-28.5-12.5T579-593L438-452ZM326-90l-58-98-110-24q-15-3-24-15.5t-7-27.5l11-113-75-86q-10-11-10-26t10-26l75-86-11-113q-2-15 7-27.5t24-15.5l110-24 58-98q8-13 22-17.5t28 1.5l104 44 104-44q14-6 28-1.5t22 17.5l58 98 110 24q15 3 24 15.5t7 27.5l-11 113 75 86q10 11 10 26t-10 26l-75 86 11 113q2 15-7 27.5T802-212l-110 24-58 98q-8 13-22 17.5T584-74l-104-44-104 44q-14 6-28 1.5T326-90Z"/></svg>
            </div>
            <div class="text">
                Тур успішно додано
            </div>
            <div class="close">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#a9a9a9"><path d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z"/></svg>
                </button>
            </div>
        </div>
    </div>
</header>
