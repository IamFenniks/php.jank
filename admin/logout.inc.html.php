<?php
    /**
     * Created by PhpStorm.
     * User: IamFennics
     * Date: 29.04.2020
     * Time: 16:42
     */
     include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
 ?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php
        $title = 'Выйти';
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h1>Выйти</h1>

                        <p>Пожалуйста выйдете из системы, если Вы завершили сегодня работу</p>

                        <form action="" method="post">
                            <div>
                                <input type="hidden" name="action" value="logout">
                                <input type="hidden" name="goto" value="/admin/">
                                <input class="btn btn-worning" type="submit" value="Выйти">
                            </div>
                        </form>

                        <p><a href="/admin/">Вернуться на Главную страницу</a></p>
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

