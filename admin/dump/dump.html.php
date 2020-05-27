<?php
/**
 * Created by PhpStorm.
 * User: Лариса
 * Date: 27.05.2020
 * Time: 21:25
 */?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    $title = 'dump';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                <h1>dump</h1>

                <h2>Dump базы данных успешно выполнен</h2>
                <p><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/index.php">Вернуться на Главную страницу</a></p>
            </div>
        </div>
    </div>
</main>
<br><hr>

<footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/footer.html.php'; ?>
</footer>

</body>
</html>
