<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 28.03.2020
 * Time: 23:52
 */

// =====================( Блок вывода авторов )===========================

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

try{
    $result = $pdo->query('SELECT author_id, author_name FROM author');
}catch(PDOException $e){
    $error = "Ошибка соединеня с БД. Извлечение списка авторов шуток. (" . $e->getMessage() . ").";
    include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
    exit();
}

foreach($result as $row){
    $authors[] = array('id' => $row['author_id'], 'name' => $row['author_name']);
}

include 'authors.html.php';

//================( Блок удаления авторов и связанных с ними ссылок в разных таблицах БД )=====================

if(isset($_POST['action']) and $_POST['action'] == 'Удалить'){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    // Извлекаем id шуток выбранного автора
    try{
        $sql = 'SELECT id FROM jokes WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':b', $_POST['id']);
        $s->execute();
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Извлечение id авторов." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        exit();
    }
    $result = $s->fetchAll();

    // Удаляем записи о категориях шуток
    try{
        $sql = 'DELETE FROM joke_category WHERE joke_id = :id';
        $s = $pdo->prepare($sql);
        foreach($result as $row){
            $jokeID = $row['joke_id'];
            $s->bindValue(':id', $jokeID);
            $s->execute();
        }
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Удаление id авторов из joke_category." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        exit();
    }

    // Удаляем шутки выбранных авторов
    try{
        $sql = 'DELETE FROM jokes WHERE author_id = :id';
        $s = $pdo->prepare($sql);
    }catch (PDOException $e){
        $error = "Ошибка соединения с БД. Удаление шуток авторов из jokes." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        exit();
    }

    // Удаляем выбранных авторов
    try{
        $sql = '';
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Удаление выбранных авторов." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        exit();
    }
}


