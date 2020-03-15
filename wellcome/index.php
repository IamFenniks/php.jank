<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 08.12.2019
 * Time: 18:33
 */
if(!isset($_REQUEST['fname'])){
    include 'form.html.php';
}else{
    $first_name = $_REQUEST['fname'];
    $last_name = $_REQUEST['lname'];
    if (($first_name == 'Андрей') && ($last_name == 'Дарменко')){
        $output = 'Приветсвует тебя, о блистательный повелитель';
    }else{
        $output = 'Добро пожаловать на наш сайт, ' .
            htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8') . ' ' .
            htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8') . '!<br>';
    }
    include 'wellcome.html.php';
}
