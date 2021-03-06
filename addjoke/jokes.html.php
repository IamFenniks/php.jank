<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>

<!doctype html>
<html lang="ru">
    <head>
        <?php
        $title = 'Сегодняшняя дата';
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
        <style type="text/css">
            input.up{margin-right: 9px;     color: white;
                margin-left: 9px;
                background-color: aquamarine;
                font-size: 16px;}
            input.down{margin-right: 9px;     color: white;
                margin-left: 9px;
                background-color: coral;
                font-size: 16px;}
            input[type="radio"]:before{display: inline-block; position: relative; top: -6px; left: -6px;
                cursor: pointer; }
            input.up:before{content: "\2B06"; }
            input.down:before{content: "\2B07";}
            input[type="radio"]:active:before{font-size: smaller; left: -3px;}
        </style>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>

                        <p><a href="?addjoke">Добавьте собственную шутку</a></p>

                        <p>Вот все шутки, которые есть в Базе Данных:</p>
                        <?php print_r($ip_key); ?>
                        <?php foreach($jokes as $i => $joke): ?>
                            <form action="?vote" method="post">
                                <blockquote>
                                    <p>
                                        <?php
                                            echo ++$i . '. ';
                                            markdownout($joke['text']);
                                        ?>
                                        (автор: <a href="mailto:<?php htmlout($joke['auth_email'])?>">
                                            <?php htmlout($joke['auth_name'])?>
                                        </a>)

                                        <input type="submit" name="voting" value="&uparrow;" class="up">
                                        <input type="submit" name="voting" value="&downarrow;" class="down">

                                        <span><?php echo $count; ?></span>

                                        <input type="hidden" name="id" value="<?php echo $joke['id'] ; ?>">
                                        <!--<input type="submit" value="Удалить">-->
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
