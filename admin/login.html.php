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
                        <h1>Войти</h1>

                        <p><strong><?php echo $text; ?></strong></p>

                        <hr>
                        <?php if(isset($loginError)): ?>
                            <p><?php htmlout($loginError); ?></p>
                        <?php endif; ?>

                        <form action="" method="post" class="col-md-4">
                            <div>
                                <label for="email">
                                    Email:
                                    <input type="text" name="email" id="email">
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
                                <input type="submit" class="btn btn-warning" value="Войти">
                            </div>

                            <?php if($flag): ?>
                                <hr>
                                <p><strong>Если Вы гость, Вы должны зарегистрировться</strong></p>

                                <a href="?to_reg" class="btn btn-warning">Регистрация</a>
                            <?php endif; ?>
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

