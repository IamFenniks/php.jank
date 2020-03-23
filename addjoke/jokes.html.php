<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Вывод шуток</title>
    </head>
    <body>
    <p><a href="?addjoke">Добавьте собственную шутку</a></p>
    <p>Вот все шутки, которые есть в Базе Данных:</p>

        <?php foreach ($jokes as $i => $joke): ?>
            <form action="?delete_joke" method="post">
                <blockquote>
                    <p>
                        <?php
                            echo ++$i . '. ' . htmlspecialchars($joke['text'], ENT_QUOTES, 'UTF-8');
                            echo '<br> (автор: <a href="mailto:" ' . htmlspecialchars($joke['auth_email'], ENT_QUOTES, 'UTF-8') .
                            '">' . htmlspecialchars($joke['auth_name'], ENT_QUOTES, 'UTF-8') . '</a>)<br>';
                        ?>

                        <input type="hidden" name="id" value="<?php echo $joke['id'] ; ?>">
                        <input type="submit" value="Удалить">
                    </p>
                </blockquote>
            </form>

        <?php endforeach; ?>
    </body>
</html>
