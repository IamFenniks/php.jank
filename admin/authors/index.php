<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 07.04.2020
 * Time: 12:40
 */

//================( Блок добления авторов  )=====================

if (isset($_GET['add'])){
    $pageTitle = 'Новый автор';
    $action = 'addform';
    $name = '';
    $email = '';
    $id = '';
    $button = 'Добавить автора';

    include 'form.html.php';
    exit();
}

if(isset($_GET['addform'])){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'INSERT INTO author SET 
            author_name = :name,
            author_email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name',  $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
        $s->execute();
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Добавление автора." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

//================( Блок редактирования автора )=====================

if(isset($_POST['action']) and $_POST['action'] == 'Редактировать'){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'SELECT author_id, author_name, author_email FROM author WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Извлечения данных автора для редактирования." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }
    $row = $s->fetch();

    $pageTitle = 'Редактировать автора';
    $action = 'editform';
    $name = $row['author_name'];
    $email = $row['author_email'];
    $id = $row['author_id'];
    $button = 'Обновить информацию об авторе';

    include 'form.html.php';
    exit();
}

if(isset($_GET['editform'])){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'UPDATE author SET 
          author_name = :name, 
          author_email = :email 
          WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
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

//================( Блок удаления авторов и связанных с ними ссылок в разных таблицах БД )=====================

if(isset($_POST['action']) and $_POST['action'] == 'Удалить'){
    $authName = $_POST['name'];
    $authID = $_POST['id'];
    include $_SERVER['DOCUMENT_ROOT'] . '/admin/confirmation.html.php';

    if(isset($_GET['confermation']) and $_GET['confermation'] = 'Удалить'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        // Извлекаем id шуток выбранного автора
        try{
            $sql = 'SELECT id FROM jokes WHERE author_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch(PDOException $e){
            $error = "Ошибка соединения с БД. Извлечение id авторов." . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
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
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        // Удаляем шутки выбранных авторов
        try{
            $sql = 'DELETE FROM jokes WHERE author_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s ->execute();
        }catch (PDOException $e){
            $error = "Ошибка соединения с БД. Удаление шуток авторов из jokes." . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        // Удаляем выбранных авторов
        try{
            $sql = 'DELETE FROM author WHERE author_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch(PDOException $e){
            $error = "Ошибка соединения с БД. Удаление выбранных авторов." . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/admin/authors/authors.html.php');
        exit();
    }
    elseif(isset($_POST['confermation']) and $_POST['confermation'] = 'Отменить'){
        header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/admin/authors/authors.html.php');
        exit();
    }
}

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

include_once 'authors.html.php';