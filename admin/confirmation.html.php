<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
        body{position: relative;}
        .pop-up{
            display: block; background-color: lightpink; border-radius: 5px; padding: 5px; position: absolute; width: 200px; height: 150px; z-index: 100; left: 45%; top: 25%; text-align: center; border: 1px solid #999;}
        .inner{
            outline: 1px solid #333; height: 100%;}
    </style>
</head>
<body>
<div class="pop-up">
    <div class="inner">
        <form action="." method="get">
            <p>Вы подтверждаете удаление автора шутки <?php echo $authName; ?>?</p>
            <input type="hidden" name="id2" value="<?php  echo $authID;?>">

            <input type="submit" name="confermation" value="Отменить">
            <input type="submit" name="confermation" value="Удалить">
        </form>
    </div>
</div>
</body>
</html>


