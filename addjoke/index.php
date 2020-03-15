<?php
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=ijdb', 'adminandrej', '14211421an');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    }catch (PDOException $e){
        $error = 'Невозможно подключиться к серверу Баз Данных!' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    try{
        $sql = 'SELECT joketext FROM jokes';
        $result = $pdo->query($sql);
    }catch (PDOException $e){
        $error = 'Ошибка при извлечении шуток' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    try{
        $sql = "UPDATE jokes SET jokedate = '2012-04-01' " .
            "WHERE joketext LIKE '%цыплёнок%'";
        $effected_rows = $pdo->exec($sql);
    }
    catch(PDOException $e){
        $error = 'Невозможно подключиться к серверу Баз Данных!' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    while ($row = $result->fetch()){
        $jokes[] = $row['joketext'];
    }

    $output = 'Соединение с Базой Данных установлено!<br>' .
        'Обновлено ' . $effected_rows . '.<br><hr>';
    include 'output.html.php';

    include 'jokes.html.php';

    if(isset($_GET['addjoke'])){
        include 'form.html.php';
        exit();
    }

    if(isset($_POST['joketext'])){
        $sql = "INSERT INTO ";
    }
