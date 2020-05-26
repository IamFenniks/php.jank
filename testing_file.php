<?php
    $output = array();

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
    $output[] = 'Соединение с Базой Данных установлено <br>';

    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //

    // РЕГУЛЯРНЫЕ ВЫРАЖЕНИЯ
    // ---------- I ---------- //
    $text = 'PHP рулит!';
    if(preg_match('/PHP/', $text)){
        $output[] = 'Текст (' . $text . ') содержит строку &ldquo; PHP &rdquo;';
    }else{$output[] = 'Текст (' . $text . ') не содержит строку &ldquo; PHP &rdquo;';}

    // ---------- II --------- //
    $text = 'Что такое PHp?';
    if(preg_match('/PHP/i', $text)){
        $output[] = 'Текст (' . $text . ') содержит строку &ldquo; PHP &rdquo;';
    }else{$output[] = 'Текст (' . $text . ') не содержит строку &ldquo; PHP &rdquo;';}

    // ---------- III --------- //
    $text = 'Этот текст содержит _курсивное_ форматирование.';
    $output[] = preg_replace('/_[^_]+_/', '<em>курсивное</em>', $text);

    // ---------- IV --------- //
    $text = 'Этот текст содержит курсивное форматирование.';
    $output[] = preg_replace('/(.*)/', '<em>курсивное</em>', $text);

    // ---------- V --------- //
//    $text = 'Этот текст содержит курсивное форматирование.';
//    $output[] = preg_replace('/*([^*]+)*/', '<em>$1</em>', $text);

    $output[] = $_SERVER['GATEWAY_INTERFACE'];
    $output[] = $_SERVER['SERVER_ADDR'];
    $output[] = $_SERVER['SERVER_NAME'];
    $output[] = $_SERVER['SERVER_SOFTWARE'];
    $output[] = $_SERVER['SERVER_PORT'];
    $output[] = $_SERVER['SERVER_PROTOCOL'];
    $output[] = $_SERVER['REQUEST_METHOD'];
    $output[] = $_SERVER['REQUEST_TIME'];
    $output[] = $_SERVER['REQUEST_URI'];
    $output[] = $_SERVER['HTTP_ACCEPT'];
    $output[] = $_SERVER['HTTP_ACCEPT_CHARSET'];
    $output[] = $_SERVER['HTTP_ACCEPT_ENCODING'];
    $output[] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $output[] = $_SERVER['HTTP_USER_AGENT'];
    $output[] = $_SERVER['REMOTE_ADDR'];
    $output[] = $_SERVER['REMOTE_USER'];
    $output[] = $_SERVER['SCRIPT_FILENAME'];
    $output[] = $_SERVER['SCRIPT_NAME'];
    $output[] = $_SERVER['SERVER_ADMIN'];

    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //

    // Подключаем файл вывода сообщения
    include 'connect/output.html.php';
