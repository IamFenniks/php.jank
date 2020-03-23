<?php
    $name =$_GET['name'];

    echo 'Добро пожаловать, на наш веб-сайт, ' .
        htmlspecialchars($name, ENT_QUOTES, 'UTF-8');