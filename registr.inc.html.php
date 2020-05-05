<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 05.05.2020
 * Time: 23:14
 */
?>
<!doctype html>
<html lang="ru">
    <head>
        <?php
            $title = 'Регистрация';
            include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
        <style type="text/css">
            form>div{position: relative;}
            form>div>label>input{position: absolute; right: 0;}
        </style>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h2>Регистрация</h2>

                        <form action="" method="post" class="col-md-4">
                            <div>
                                <label for="name">Ваше имя:
                                    <input type="text" id="name" name="name" placeholder="Андрей Андреев">
                                </label>
                            </div>

                            <div>
                                <label for="email">Ваш ящик:
                                    <input type="text" id="name" name="name" placeholder="andrei@mail.com">
                                </label>
                            </div>

                            <div>
                                <label for="password1">Пароль:
                                    <input type="password" id="password1" name="password1">
                                </label>
                            </div>
                            <div>
                                <label for="password2">Подтвердить пароль:
                                    <input type="password" id="password2" name="password2">
                                </label>
                            </div>
                            <div>
                                <input type="hidden" name="action" value="registr">
                                <input type="submit" value="Регистрация" class="btn btn-success">
                            </div>
                        </form>
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
