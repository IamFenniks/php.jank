<?php
    /**
     * Created by PhpStorm.
     * User: andre
     * Date: 22.03.2020
     * Time: 14:47
     */

    try{
        $pdo = new PDO('mysql:host=localhost;dbname=ijdb', 'adminandrej', '14211421an');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    }catch (PDOException $e){
        $error = 'Невозможно подключиться к серверу Баз Данных!' . $e->getMessage();
        include 'error.html.php';
        exit();
    }