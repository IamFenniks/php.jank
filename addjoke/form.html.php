<!doctype html>
<html lang="ru">
    <head>
        <?php
            $title = 'Добавление шутки';
            include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
        <style type="text/css">
            textarea{
                display: block;
                width: 100%;
            }
        </style>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h2>Добавление шутки</h2>

                        <!--
                            <form action="<?php // echo $_SERVER['PHP_SELF']; ?>"> Обрабатывается сдесь же
                            <form action=""> Возврашаемтся на сценарий, с которого форма была вызвана
                            <form action="?"> Возврашаемтся на сценарий, с которого форма была вызвана с использованием:
                                if(isset($_GET['addjoke'])) И
                                <a href="?addjoke">
                        -->

                        <form action="?" method="post">
                            <div>
                                <label for="joketext">Введите сюда свою шутку:</label>
                                <textarea name="joketext" id="joketext" cols="30" rows="10"></textarea>
                            </div>
                            <div><input type="submit" value="Добавить"></div>
                        </form>

                        <p><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/logout.inc.html.php'; ?></p>
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
