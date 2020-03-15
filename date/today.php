<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Сегодняшняя дата</title>
    <body>

        <!--<?php require '../index.php';?>-->

        <p>Ctгодняшняя дата (согласно данному веб-серверу):
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
    </body>
</html>
 