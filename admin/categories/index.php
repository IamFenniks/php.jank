<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 08.04.2020
 * Time: 20:20
 */

// ---------------------------- Добавление категорий --------------------
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
if(isset($_GET['addform'])){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'INSERT INTO category SET 
            category_name = :name';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name',  $_POST['name']);
        $s->execute();
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Добавление автора." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

//==================================================================================

// ------------------------------Блок редактирования категорий ------------
// Получение сигнала из формы со страницы вывода всех категорий
if(isset($_POST['action']) and $_POST['action'] == 'Редактировать'){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'SELECT id, category_name FROM category WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }catch(PDOException $e){
        $error = 'Ошибка выборки категории для редактирования' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    $row = $s->fetch();
    $pageTitle = 'Редактировать категорию';
    $action = 'editform';
    $name = $row['category_name'];
    $id = $row['id'];
    $button = 'Редактировать категорию';

    include 'form.html.php';
    exit();
}

// Обновление котегории
if(isset($_GET['editform'])){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'UPDATE category SET 
          category_name = :name
          WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Редактирования данных автора." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

//==================================================================================

// ---------------- Блок удаления категории -------------------------
if(isset($_POST['action']) && $_POST['action'] == 'Удалить'){
    include $_SERVER['DOCUMENT_ROOT'] . "/includes/db.inc.php";
    // Улаление ссылки из промежуточной таблицы
    try{
        $sql = 'DELETE FROM joke_category WHERE category_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }catch (PDOException $e){
        $error = 'Ошибка удаления внешнего ключа из промежуточной таблицы';
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    // Удаление самой категории
    try{
        $sql = 'DELETE FROM category WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }catch (PDOException $e){
        $error = 'Ошибка удаления категории';
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }
    
    header('Location: .');
    exit();
}

//==================================================================================

//----------------- Блок вывода всех категорий ----------------------
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try{
    $resultArr = $pdo->query('SELECT id, category_name FROM category');
}catch (PDOException $e){
    $error = 'Ошибка вывода категорий из БД' . $e->getMessage();
    include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
    exit();
}

foreach($resultArr as $row){
    $categories[] = array('id' => $row['id'], 'name' => $row['category_name']);
}

include 'categories.html.php';
