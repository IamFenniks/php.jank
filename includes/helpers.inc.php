<?php
/**
 * Created by PhpStorm.
 * User: Лариса
 * Date: 28.03.2020
 * Time: 19:39
 */

function html($text){
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text){
    echo html($text);
}

function markdown2html($text){
    $text = htmlout($text);

    // Полужирное начертание
    $text = preg_replace('/__(.+?)__/s', '<em>$1</em>', $text);
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<em>$1</em>', $text);

    // Курсивное начертание
    $text = preg_replace('/_(.+?)_/s', '<em>$1</em>', $text);
    $text = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $text);


    // Преобразуем стиль Windows в Unix
    $text = preg_replace('/\n\r/', "\n", $text);

    // Преобразуем стиль Macintosh в Unix
    $text = preg_replace('/n\r/', "\n", $text);

    // Абзацы
    $text = '<p>' . preg_replace('/\n\n/', '<p></p>', $text) . '</p>';

    // Разрывы строки
    $text = preg_replace('/\n/', '<br>', $text);


    // ????????????????   - ИЛИ - ???????????????????? //
    /* Преобразуем стиль Windows в Unix
        *$text = str_replace("\n\r", "\n", $text);

        *Преобразуем стиль Macintosh в Unix
        *$text = str_replace("n\r", "\n", $text);

        *Абзацы
        *$text = '<p>' . str_replace("\n\n", '<p></p>', $text) . '</p>';

        *Разрывы строки
        $text = str_replace("\n", '<br>', $text);
    */

    // [Текст ссылки] (Адрес URL)
    $text = preg_replace('/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&`()*+,;=%]+)\)/i',
            '<a href="$2">$1</a>', $text);

    return $text;
}

function markdownout($text){
    echo markdown2html($text);
}

function getIP(){

    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_x_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];

    foreach ($keys as $key){
        if(!empty($_SERVER[$key])){
            $userIP = trim(end(explode(',', $_SERVER[$key])));
            if(filter_var($userIP, FILTER_VALIDATE_IP)) return $ip_key = [$userIP => $key];
        }
    }
}
