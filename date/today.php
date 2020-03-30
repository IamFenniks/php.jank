<!doctype html>
<html lang="ru">
    <head>
        <?php
            $title = 'Сегодняшняя дата';
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
    </head>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>

        <p>Cегодняшняя дата (согласно данному веб-серверу):
            <?php
                echo date('l, F jS Y.');
                echo '<br>';
            ?>

        </p>

        <p>
            Создание массивов:
            <?php
                $arr = array('Один', 2, '3');
                $arr[0] = 1;
                $arr[] = 'четвёртый элемент';

                //    -- I --
                $birth_day['Кевин'] = '23-12-2012';
                $birth_day['Стефани'] = '23-12-2012';
                $birth_day['Девид'] = '23-12-2012';

                //    -- II --
                $birth_day = array('Кевин' => '23-12-2012', 'Стефани' => '23-12-2012', 'Девид' => '23-12-2012');

                echo 'День рождения Стефани: ' . $birth_day['Стефани'];
            ?>
        </p>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/footer.html.php'; ?>
    </body>
</html>
 