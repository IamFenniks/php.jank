<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 07.04.2020
 * Time: 12:40
 */

// ================( Блок авторизации администратора учетных записей  )=====================

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

if(!userIsLoggedIn()) {              // Если( заходим в файл доступа обращаемся к функции ПОЛЬЗОВАТЕЛЬ НЕ ОПРЕДЕЛЕН, ТО...
    $text = 'Пожалуйста войдите в систему, чтобы редактировать страницу, к которой Вы обратились';
    $flag = false;
    include '../login.html.php';    // ПОСЫЛАЕМ В ФОРМУ
    exit();                         // ВЫХОДИМ
}                                   // ВСЕ ОК ИДЕМ ДАЛЕЕ

if(!userHasRole('Администратор учётных записей')){
    $error = 'Доступ к этой странице имеет только "Администратор учётных записей"';
    include '../accessdenied.html.php';
    exit();
}
// ==========================( Блок добления авторов  )=====================

if (isset($_GET['add'])){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    $pageTitle = 'Новый автор';
    $action = 'addform';
    $name = '';
    $email = '';
    $id = '';
    $button = 'Добавить автора';

    try{
        $result = $pdo->query('SELECT id, description FROM role');
    }catch (PDOException $e){
        $error = 'Ошибка извлечениея ролей' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }
    foreach ($result as $row){
        $roles[] = array('id' => $row['id'], 'description' => $row['description'], 'selected' => false);
    }

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

    $authID = $pdo->lastInsertId();

    if($_POST['password'] != ''){
        try{
            $sql = 'UPDATE author SET password = :password WHERE author_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':password', md5($_POST['password'] . 'ijdb'));
            $s->bindValue(':id', $authID);
            $s->execute();
        }catch (PDOException $e){

            $error = "Ошибка соединения с БД. Добавление пароля автора." . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

    }

    if (isset($_POST['roles'])){
        foreach ($_POST['roles'] as $role)
        try{
            $sql = 'INSERT INTO author_role SET 
                    author_id = :authorID,
                    roel_id = :roleID';
            $s = $pdo->prepare($sql);
            $s->bindValue(':authorID', $authID);
            $s->bindValue('roleID', $role);
            $s->execute();
        }catch (PDOException $e){
            $error = "Ошибка соединения с БД. Добавление роли автора." . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

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

    // Получаем список ролей назначенных автору
    try {
        $sql = 'SELECT role_id FROM author_role WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Извлечения ролей автора для редактирования." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    $selectedRoles = array();
    foreach ($s as $row){
        $selectedRoles[] = $row['role_id'];
    }

    // Формируем список всех ролей
    try{
        $result = $pdo->query('SELECT id, description FROM role');
    }catch(PDOException $e){
        $error = "Ошибка соединения с БД. Извлечения всех ролей для формы редактирования." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }
    foreach ($result as $row){
        $roles[] = array(
            'id' => $row['id'],
            'description' => $row['description'],
            'selected' => in_array($row['id'], $selectedRoles)
        );
    }

    include 'form.html.php';
    exit();
}

if(isset($_GET['editform'])){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    // Обновление имени и почты автора
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

    // Необязательное обновление пароля автора
    if($_POST['password'] != ''){
        $password = md5($_POST['password'] . 'ijdb');
        try{
            $sql = 'UPDATE author SET password = :password WHERE author_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':password', $password);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch(PDOException $e){
            $error = "Ошибка обновления пароля автора." . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }
    }

    // Удаление невыбранных из ранее выбранных ролей автора
    try{
        $sql = 'DELETE FROM author_role WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }catch(PDOException $e){
        $error = "Ошибка удаления при редактировании ролей автора." . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    if(isset($_POST['roles'])){
        foreach ($_POST['roles'] as $role){
            try{
                $sql = 'INSERT INTO author_role SET 
                        author_id = :authID,
                        role_id = :roleID';
                $s = $pdo->prepare($sql);
                $s->bindValue(':authID', $_POST['id']);
                $s->bindValue(':roleID', $role);
                $s->execute();
            }catch(PDOException $e){
                $error = "Ошибка при назначении автору заданных ролей." . $e->getMessage();
                include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
                exit();
            }
        }

    }

    header('Location: .');
    exit();
}

//================( Блок удаления авторов и связанных с ними ссылок в разных таблицах БД )=====================

if(isset($_POST['action']) and $_POST['action'] == 'Удалить'){
    $authName = $_POST['name'];
    $authID = $_POST['id'];
    include $_SERVER['DOCUMENT_ROOT'] . '/admin/confirmation.html.php';

    if($_GET['confermation'] == 'Удалить'){
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
        // Удаляем роли выбранного автора
        try {
            $sql = 'DELETE FROM author_role WHERE author_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch(PDOException $e){
            $error = "Ошибка удаления ролей удаляемого автора." . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        header('Location: .');
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