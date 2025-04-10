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
        <?php include 'contacts_style.css'?>
        <?php include 'views/components/header/header.css'?>
        <?php include 'views/components/footer/footer.css'?>
    </style>
</head>

<body>
<?php include 'views/components/header/header.php'?>

<div class="scroll-bar">
    <main class="contacts">
        <div class="contacts-header">
            <div>
                <h2>Зв'язатися з нами</h2>
                <p>Нижче ви зможете знайти контактні дані якщо у вас виникли запитання, та/або необхідно підібрати тур</p>
            </div>
            <img src="/files/static/contacts.jpg">
        </div>
        <div class="cards-wrapper">
            <div class="card">
                <h2>Contact us</h2>
                <div class="card-contacts">
                    <div>
                        <i class="material-icons">phone_in_talk</i>
                        +380 23 477 28 29
                    </div>
                    <div>
                        <i class="material-icons">alternate_email</i>
                        aboba@gmail.com
                    </div>
                    <div>
                        <i class="material-icons">location_on</i>
                        Chudnivska St, 103, Zhytomyr, Zhytomyr Oblast, 10005
                    </div>
                </div>
            </div>
            <div class="card">
                <h2>Заявка на тур</h2>
                <form>
                    <div class="input-wrapper">
                        <div>
                            <i class="material-icons">person</i>
                        </div>
                        <input placeholder="Ім'я"/>
                    </div>
                    <div class="input-wrapper">
                        <div>
                            <i class="material-icons">call</i>
                        </div>
                        <input placeholder="Номер телефону"/>
                    </div>
                    <div class="input-wrapper">
                        <div>
                            <i class="material-icons">comment</i>
                        </div>
                        <textarea placeholder="Кометар"></textarea>
                    </div>

                    <button class="button-6">Відправити заявку</button>
                </form>
            </div>
        </div>
    </main>

    <?php include 'views/components/footer/footer.php'?>
</div>


<script>
    <?php include 'views/components/header/header_script.js' ?>
</script>
</body>
</html>