<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>

<!doctype html>
<html lang="ru">
    <head>
        <?php
        $title = 'Сегодняшняя дата';
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>

                        <p><a href="?addjoke">Добавьте собственную шутку</a></p>

                        <p>Вот все шутки, которые есть в Базе Данных:</p>

                        <?php foreach($jokes as $i => $joke): ?>
                            <form action="?delete_joke" method="post">
                                <blockquote>
                                    <p>
                                        <?php
                                            echo ++$i . '. ';
                                            markdownout($joke['text']);
                                        ?>
                                        (автор: <a href="mailto:<?php htmlout($joke['auth_email'])?>">
                                            <?php htmlout($joke['auth_name'])?>
                                        </a>)

                                        <input type="hidden" name="id" value="<?php echo $joke['id'] ; ?>">
<!--                                        <input type="submit" value="Удалить">-->
                                        <br>
                                    </p>
                                </blockquote>
                            </form>
                        <?php endforeach; ?>
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
