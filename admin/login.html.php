<?php
/**
 * Created by PhpStorm.
 * User: IamFenniks
 * Date: 29.04.2020
 * Time: 11:47
 */
 include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php
        $title = 'Войти';
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h1>Войти</h1>

                        <p>Пожалуйста войдите в систему, чтобы просмотреть страницу, к которой Вы обратились</p>

                        <?php if(isset($loginError)): ?>
                            <p><?php htmlout($loginError); ?></p>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div>
                                <label for="email">
                                    Email:
                                    <input type="email" name="email" id="email">
                                </label>
                            </div>

                            <div>
                                <label for="password">
                                    Пароль:
                                    <input type="password" name="password" id="password">
                                </label>
                            </div>

                            <div>
                                <input type="hidden" name="action" value="login">
                                <input class="btn btn-worning" type="submit" value="Войти">
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

