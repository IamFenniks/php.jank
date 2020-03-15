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
            <blockquote>
                <p>
                    <?php echo ++$i . '. ' . htmlspecialchars($joke, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </blockquote>
        <?php endforeach; ?>
    </body>
</html>
