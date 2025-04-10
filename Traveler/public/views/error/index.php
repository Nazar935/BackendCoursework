<?php
/** @var $error */
/** @var $message */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'views/components/metadata.php' ?>

    <title>Traveler - Error <?= $error?></title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'views/components/header/header.css' ?>
        <?php include 'views/components/footer/footer.css' ?>
        <?php include 'error_style.css'?>
    </style>
</head>

<body>

<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main class="error-page">
        <div class="image-wrapper">
            <img src="/files/static/error.png" alt="error"/>
            <div class="error-code"><?= $error?></div>
        </div>
        <div class="error-text">
            <h2><?= isset($message) ? $message['header'] : "Сторінка, яку ви шукали, не існує... :("?></h2>
            <p><?= isset($message) ? $message['text'] : "Можливо, ви ввели неправильну адресу, або сторінку перенесли"?></p>
        </div>
    </main>
    <?php include 'views/components/footer/footer.php' ?>
</div>

</body>

<script>
    <?php include 'views/components/header/header_script.js' ?>
</script>

</html>