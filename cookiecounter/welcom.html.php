<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    $title = 'Счётчик cookies';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                <h1>Счётчик cookies</h1>

                <?php
                    if($visits > 1){
                        echo "Номер данного посещения $visits.";
                    }else{
                        echo 'Добро пожаловать на мой сайт. Кликните здесь, чтобы узнать больше.';
                    }
                ?>
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