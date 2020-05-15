<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 05.05.2020
 * Time: 23:14
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
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
            .error{color: coral;}
        </style>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h2>Регистрация</h2>

                        <p><?php echo $text; ?></p>

                        <hr>

                        <form action="" method="post" class="col-md-4">
                            <div>
                                <label for="name">Ваше имя:
                                    <input type="text" id="name" name="name" value="">
                                    <?php if(isset($nameError)): ?>
                                        <p class="error"><?php htmlout($nameError); ?></p>
                                    <?php endif; ?>
                                </label>
                            </div>

                            <div>
                                <label for="email">Ваш ящик:
                                    <input type="email" id="email" name="email">
                                    <?php if(isset($emailError)): ?>
                                        <p class="error"><?php htmlout($emailError); ?></p>
                                    <?php endif; ?>
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

                                <?php if(isset($password1Error)): ?>
                                    <p class="error"><?php htmlout($password1Error); ?></p>
                                <?php endif; ?>

                                <?php if(isset($password2Error)): ?>
                                    <p class="error"><?php htmlout($password2Error); ?></p>
                                <?php endif; ?>

                                <?php if(isset($passError)): ?>
                                    <p class="error"><?php htmlout($passError); ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <input type="hidden" name="action" value="reg_form">
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
