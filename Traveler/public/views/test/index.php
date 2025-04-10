<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'views/components/metadata.php' ?>

    <title>Traveler - Error <?= $error?></title>
    <style>
        <?php include 'views/components/global/global_css_includes.php'?>
        <?php include 'views/components/header/header.css' ?>
        <?php include 'views/components/footer/footer.css' ?>
        <?php include 'test_style.css'?>
    </style>
</head>

<body>

<?php include 'views/components/header/header.php'?>

<main class="test-page">
    <h1>test</h1>
    <ul id="sortable-list">
        <li>
            <div>
                <button class="drag-handle">☰ Перетащить</button>
                <p>Элемент 1</p>
            </div>
        </li>
        <li>
            <div>
                <button class="drag-handle">☰ Перетащить</button>
                <p>Элемент 2</p>
            </div>
        </li>
        <li>
            <div>
                <button class="drag-handle">☰ Перетащить</button>
                <p>Элемент 3</p>
            </div>
        </li>
    </ul>


</main>

<?php include 'views/components/footer/footer.php' ?>

</body>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    <?php include 'test_script.js' ?>
</script>

</html>