<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Добавление шутки</title>
        <style type="text/css">
            textarea{
                display: block;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <h2>Добавление шутки</h2>

        <!--
            <form action="<?php // echo $_SERVER['PHP_SELF']; ?>"> Обрабатывается сдесь же
            <form action="?"> Возврашаемтся на сценарий, с которого форма была вызвана
            <form action="?"> Возврашаемтся на сценарий, с которого форма была вызвана с использованием:
                if(isset($_GIT['addjoke'])) И
                <a href="?addjoke">
        -->
        <form action="?" method="post">
            <div>
                <label for="joketext">Введите сюда свою шутку:</label>
                <textarea name="joketext" id="joketext" cols="30" rows="10"></textarea>
            </div>
            <div><input type="submit"></div>
        </form>
    </body>
</html>
