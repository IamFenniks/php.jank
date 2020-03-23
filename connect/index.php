<?php
    try{
        $pdo = new PDO('mysql:host=localhost; dbname=ijdb', 'adminandrej', '14211421an');
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo -> exec('SET NAMES "utf8"');
    }catch(PDOException $e){
        echo 'Ошибка соединения с сервером базы данных:<br>' . $e -> getMessage();
        include 'output.html.php';
        exit();
    }
    echo 'Hi, it`s me. DB!';
    include 'output.html.php';

    try{
        $sql = "INSERT INTO jokes SET " .
            "joketext'Зачем цыплёнок перешёл дорогу? Чтобы попасть на другую сторону!', '24-02-2020')";
        $pdo -> exec($sql);
    }
    catch(PDOException $e){
        echo 'Ошибка запроса, input:<br>' . $e -> getMessage();
        include 'output.html.php';
        exit();
    }

    try{
        $sql = "SELECT * FROM jokes";
        $result = $pdo -> exec($sql);
    }
        catch(PDOException $e){
        echo 'Ошибка запроса, output:<br>' . $e -> getMessage();
        include 'output.html.php';
        exit();
    }
    foreach($result as $row){
        $jokes[] = $row['joketext'];
    }
    foreach ($jokes as $joke){
        echo $joke;
    }
    include 'output.html.php';

