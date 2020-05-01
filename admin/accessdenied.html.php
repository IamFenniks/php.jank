<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 29.04.2020
 * Time: 11:53
 */
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    $title = 'Доступ запрещён!';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                <h1>Доступ запрещён!</h1>

                <p><?php htmlout($error); ?></p>
                <p><a href="">Авторизоваться</a></p>
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
