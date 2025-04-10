<?php
/** @var string $error */
/** @var array $model */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/favicon.ico">

    <title>Traveler - Home</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'login_style.css'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'form_error_style.css'?>
    </style>
</head>

<body>
    <?php include 'views/components/header/header.php' ?>

    <div class="scroll-bar">
        <main class="login">
            <div class="form-wrapper">
                <form method="POST" action="">
                    <h1>Увійти</h1>
                    <?php if (isset($error)) :?>
                        <div class="input-wrapper icon-input">
                            <input placeholder="Ім'я користувача" name="username" value="<?= $model['username'] ?>" autocomplete="off">
                            <i class="material-icons">account_box</i>
                        </div>
                        <div class="input-wrapper icon-input password">
                            <input class="focus" placeholder="Пароль" name="password" type="password" value="<?= $model['password'] ?>" autocomplete="off">
                            <i class="material-icons">password</i>
                        </div>
                        <div class="form-error-wrapper" id="form-error">
                            <div class="error">
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" ><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                </i>
                                <div class="text-wrapper">
                                    <?= $error ?>
                                </div>
                            </div>
                            <div class="button-wrapper">
                                <button type="button" class="remove-error">
                                    <i class="material-icons">close</i>
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="input-wrapper icon-input">
                            <input placeholder="Ім'я користувача" name="username" autocomplete="off">
                            <i class="material-icons">account_box</i>
                        </div>
                        <div class="input-wrapper icon-input password">
                            <input placeholder="Пароль" name="password" type="password" autocomplete="off">
                            <i class="material-icons">password</i>
                        </div>
                    <?php endif; ?>
                    <div class="link-wrapper">
                        <a href="/user/register" class="link">
                            <div class="underline"></div>
                            Я ще не маю аккаунт
                        </a>

                    </div>
                    <button class="btn-4">Увійти</button>
                </form>
            </div>
            <img src="/files/static/login.png" alt="login"/>
        </main>
        <?php include 'views/components/footer/footer.php' ?>
    </div>

    <script>
        <?php include 'views/components/header/header_script.js' ?>
        <?php include 'views/tours/view/save/save_button_script.js'?>
        <?php include 'form_error_script.js'?>
        <?php include 'login_script.js' ?>
    </script>
</body>
</html>