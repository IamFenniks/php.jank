<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 20.04.2020
 * Time: 15:21
 */

    if(!isset($_COOKIE['visits'])){
        $_COOKIE['visits'] = 0;
    }

    $visits = $_COOKIE['visits'] + 1;
    setcookie('visits', $visits, time()  + 3600 * 24 * 365);

    include 'welcom.html.php';
