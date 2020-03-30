<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    $title = 'Шуточная CMS';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                <h1>Система Управления Шутками</h1>
                <ul>
                    <li><a href="jokes/">Управление шутками</a></li>
                    <li><a href="authors/index.php">Управление авторами</a></li>
                    <li><a href="categories/">Управление категориями шуток</a></li>
                </ul>
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