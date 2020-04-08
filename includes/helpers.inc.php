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
