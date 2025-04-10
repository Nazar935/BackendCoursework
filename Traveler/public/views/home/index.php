<?php

use models\User;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'views/components/metadata.php' ?>

    <link rel="icon" href="/files/static/favicon.ico">

    <title>Traveler - Home</title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'home_style.css'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
        <?php include 'slider/slider.css'?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<main class="home">
    <?php include 'slider/slider.php' ?>
</main>

<?php include 'views/components/footer/footer.php'?>

<script>
    <?php include 'views/components/header/header_script.js'?>
    <?php include 'hide_menu.js'?>
    <?php include 'slider/slider.js'?>
</script>
</body>
</html>