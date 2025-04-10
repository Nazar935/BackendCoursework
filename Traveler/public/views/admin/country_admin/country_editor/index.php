<?php

use models\User;

/** @var array $country */
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
        <?php include 'country_editor_style.css'?>
        <?php include 'file_input_styles.css'?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main class="country-editor">
        <h1 class="cool-header">
            <span class="header-text">
                <?php if (isset($country)) : ?>
                    Змінити дані про <span class="underline">країну</span>
                <?php else: ?>
                    Додати нову <span class="underline">країну</span>
                <?php endif; ?>
            </span>
        </h1>
        <div class="form-wrapper">
            <form   id="country-form"
                <?php if (isset($country)) : ?>
                    action="/admin/country/<?= $country['en_name']?>"
                <?php else: ?>
                    action="/admin/country"
                <?php endif; ?>
                    method="post"
                    enctype="multipart/form-data"
            >
                <div class="grid">
                    <div class="left">
                        <div class="ua-name">
                            <span class="input-header">Назва українською:</span>
                            <div class="input-wrapper">
                                <input id="ua_name" name="ua_name" type="text" autocomplete="off" spellcheck="false"
                                    <?php if (isset($country)) : ?>
                                        value="<?= $country['ua_name']?>"
                                    <?php endif; ?>
                                />
                            </div>
                        </div>
                        <div class="en-name">
                            <span class="input-header">Назва анлійською:</span>
                            <div class="input-wrapper input-with-icon">
                                <span class="icon">/</span>
                                <input id="en_name" name="en_name" type="text" autocomplete="off" spellcheck="false"
                                    <?php if (isset($country)) : ?>
                                        value="<?= $country['en_name']?>"
                                        data-previous-value="<?= $country['en_name']?>"
                                    <?php endif; ?>
                                />
                            </div>
                        </div>
                        <div class="big-line-horizontal"></div>
                        <div class="table">
                            <div class="flag file">
                                <span class="file-header">Прапор:</span>
                                <?php if (isset($country)) : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper hide-controllers">
                                            <label for="flag">
                                                <i class="material-icons">edit</i>
                                                <input id="flag" name="flag" type="file" accept="image/svg+xml"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <img id="server-flag" class="src-target display-target" src="/files/countries/flags/<?= $country['flag']?>" alt="<?= $country['en_name']?>-flag"/>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper">
                                            <label for="flag">
                                                <i class="material-icons">add_photo_alternate</i>
                                                <input id="flag" name="flag" type="file" accept="image/svg+xml"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <img class="src-target display-target" alt="flag" style="display: none"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="pattern file">
                                <span class="file-header">Паттерн:</span>
                                <?php if (isset($country)) : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper hide-controllers">
                                            <label for="pattern">
                                                <i class="material-icons">edit</i>
                                                <input id="pattern" name="pattern" type="file" accept="image/*"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <img id="server-pattern" class="src-target display-target" src="/files/countries/patterns/<?= $country['pattern']?>" alt="<?= $country['en_name']?>-pattern"/>

                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper">
                                            <label for="pattern">
                                                <i class="material-icons">add_photo_alternate</i>
                                                <input id="pattern" name="pattern" type="file" accept="image/*"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <img class="src-target display-target" alt="pattern" style="display: none"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="video file">
                                <span class="file-header">Відео:</span>
                                <?php if (isset($country)) : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper hide-controllers">
                                            <label for="video" class="hide">
                                                <i class="material-icons">edit</i>
                                                <input id="video" name="video" type="file" accept="video/*"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <video id="server-video" class="display-target" loop preload="auto" autoplay muted disablePictureInPicture >
                                                    <source class="src-target" src="/files/countries/videos/<?= $country['video']?>" type="video/webm"/>
                                                </video>
                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper">
                                            <label for="video">
                                                <i class="material-icons">video_call</i>
                                                <input id="video" name="video" type="file" accept="video/*"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <video class="display-target" style="display: none" loop preload="auto" autoplay muted disablePictureInPicture >
                                                    <source class="src-target" src="" type="video/webm"/>
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="cover file">
                                <span class="file-header">Обкладинка:</span>
                                <?php if (isset($country)) : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper hide-controllers">
                                            <label for="cover" class="hide">
                                                <i class="material-icons">edit</i>
                                                <input id="cover" name="cover" type="file" accept="image/*"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <img id="server-cover" class="src-target display-target" src="/files/countries/covers/<?= $country['cover']?>" alt="<?= $country['en_name']?>-cover"/>

                                            </div>
                                        </div>
                                    </div>

                                <?php else : ?>
                                    <div class="display-wrapper file-input">

                                        <div class="image-wrapper">
                                            <label for="cover">
                                                <i class="material-icons">add_photo_alternate</i>
                                                <input id="cover" name="cover" type="file" accept="image/*"/>
                                            </label>
                                            <div class="bg">
                                                <div class="filter"></div>
                                                <img class="src-target display-target" alt="cover" style="display: none"/>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="bg">
                                <div class="line-vertical"></div>
                                <div class="line-horizontal"></div>
                            </div>
                        </div>
                    </div>
                    <div class="big-line-vertical"></div>
                    <div class="right">
                        <div class="cities-wrapper">
                            <h2>Міста</h2>
                            <div class="line"></div>
                            <div class="cities">
                                <?php if (isset($country)) : ?>
                                    <?php foreach ($country['cities'] as $index => $city) : ?>
                                        <div class='city'>
                                            <div class="display-wrapper file-input small">
                                                <div class="image-wrapper hide-controllers">
                                                    <label for="city-<?= $index ?>" class="hide">
                                                        <i class="material-icons">edit</i>
                                                        <input class="city-flag" id="city-<?= $index ?>" name="city_flag[]" type="file" accept="image/svg+xml"/>
                                                    </label>
                                                    <div class="bg">
                                                        <div class="filter"></div>
                                                        <img class="src-target display-target server-city-flag" src="/files/countries/city/<?= $city['flag']?>" alt="<?= $city['link']?>-cover"/>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="middle">
                                                <input class="city-name" type="text" name="city_name[]" value="<?= $city['name']?>" placeholder="Назва (UA)" autocomplete="off" spellcheck="false"/>
                                                <div class="input-wrapper input-with-icon">
                                                    <span class="icon">/</span>
                                                    <input class="city-link" type="text" name="city_link[]" value="<?= $city['link']?>" data-previous-value="<?= $city['link']?>" placeholder="Назва (EN)" autocomplete="off" spellcheck="false"/>
                                                </div>
                                                <input name="city_id[]" value="<?= $city['city_id']?>" style="display: none"/>
                                            </div>
                                            <div class="button-wrapper">
                                                <button type="button" class="city-delete">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="line"></div>
                            <button type="button" class="add-city simple-button">
                                <span class="icon">
                                    <i class="material-icons">post_add</i>
                                </span>
                                <span class="text">Додати місто</span>
                            </button>
                        </div>
                    </div>
                </div>
                <button class="accent-button">
                    <span>Зберегти</span>
                    <i class="material-icons">task_alt</i>
                </button>
                <?php /*if (isset($country)) : */?><!--

                <?php /*else: */?>
                    <button class="accent-button">
                        <span>Додати</span>
                        <i class="material-icons">add</i>
                    </button>
                --><?php /*endif; */?>
            </form>
        </div>

    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>


<script>
    <?php include 'views/components/header/header_script.js' ?>
    <?php include 'country_editor_script.js'?>
    <?php include 'file_input_script.js'?>
</script>
</body>
</html>