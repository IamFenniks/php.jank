<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Method GET и пример формы</title>
</head>
<body>
<!--    <a href="name.php?fname=Девид&amp;lname=Коперфильд">Привет! Меня зовут Девид.</a>-->

    <form action="" method="post">
        <div for="fname">
            <lable>Имя: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="text" id="fname" name="fname"></lable>
        </div>
        <div for="lname">
            <lable>Фамилия: <input type="text" id="lname" name="lname"></lable>
        </div><br>
        <div><input type="submit" name="submit" value="Поехали!"></div>
    </form>
</body>
</html>