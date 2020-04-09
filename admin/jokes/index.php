<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 09.04.2020
 * Time: 14:37
 */

// Выводим форму поиска
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

// Получаем автров
try{
    $result = $pdo->query('SELECT author_id, author_name FROM author');
}catch (PDOException $e){

    $error = 'Ошибка извлечения имени автора';
    include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
    exit();
}

foreach ($result as $row){
    $authors[] = array('id' => $row['author_id'], 'name' => $row['author_name']);
}

//Получаем категории
try{
    $result = $pdo->query('SELECT id, category_name FROM category');
}catch (PDOException $e){

    $error = 'Ошибка извлечения имени автора';
    include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
    exit();
}

foreach ($result as $row){
    $categories[] = array('id' => $row['id'], 'name' => $row['category_name']);
}

$pageTitle = 'Управление шутками';
include 'searchform.html.php';

if(isset($_GET['action']) && $_GET['action'] == 'search'){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    // Базовое выражение SELECT
    $select = 'SELECT id, joketext';
    $from   = ' FROM jokes';
    $where  = ' WHERE TRUE';

    $placeholders = array();
    if($_GET['author'] != ''){ // Автор выбран
        $where .= 'AND author_id = :author_id';
        $placeholders[':author_id'] = $_GET['author'];
    }

    if($_GET['category']){// Категория выбрана
        $from .= 'INNER JOIN joke_category ON id = joke_id';
        $where .= 'AND category_id = :category_id';
        $placeholders[':category_id'] = $_GET['category'];
    }
}




























