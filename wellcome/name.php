<?php
$first_name = $_REQUEST['fname'];
$last_name = $_REQUEST['lname'];

if (($first_name == 'Андрей') && ($last_name == 'Дарменко')){
    echo 'Приветсвует тебя, о блистательный повелитель';
}else{
    echo 'Добро пожаловать на наш сайт, ' .
        htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8') . ' ' .
        htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8') . '!<br>';
}
