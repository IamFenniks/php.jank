<?php
    try{
        // Создаем объект PDO
        $pdo = new PDO('mysql:host=localhost; dbname=ijdb', 'adminandrej', '14211421an');
        // Конфигурируе поведение объекта при обработке ошибок
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Осуществляем запрос с помощью PDO метода "exec()" для установки кодировки
        $pdo->exec('SET NAMES "utf8"');
    }
    catch (PDOException $e){
        // Сохранение описания ошибки в пременную
        $error = 'Невозможно подключиться к Базе Данных<br>' . $e->getMessage();
        // Подключаем файл вывода ошбики
        include 'connect/error.html.php';
        // Выход из программы
        exit();
    }
    // Сообщение об успешном подключении к Базе Данных
    $output = 'Соединение с Базой Данных установлено';
    // Подключаем файл вывода сообщения
    include 'connect/output.html.php';
