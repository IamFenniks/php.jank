<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 08.04.2020
 * Time: 20:20
 */

// Добавление категорий
// Принимаем сигнал добавления со страницы вывода всех категорий по тегу <a>
if(isset($_GET['add'])){

    $pageTitle = 'Добавление категории';
    $action = 'addform';
    $name = '';
    $id = '';
    $button = 'Добавить категорию';

    include 'form.html.php';
    exit();
}

//Принимаем сигнал из формы добавления\редактирования
if($_GET['addform']){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'INSERT INTO category SET 
            category_name = :name';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->execute();
    }catch (PDOException $e){
        $error = 'Ошибка добавления категории в БД' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}

// Блок редактирования категорий
// Получение сигнала из формы со страницы вывода  всех категорий
if(isset($_POST['action']) and $_POST['action'] == 'Редактировать'){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'UPDATE category SET';
    }catch(PDOException $e){

    }
}

include 'categories.html.php';
