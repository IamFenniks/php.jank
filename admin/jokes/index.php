<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 09.04.2020
 * Time: 14:37
 */

    // Блок добавления шуток
    if(isset($_GET['add'])){
        $pageTitle = 'Новая шутка';
        $action = 'addform';
        $text = '';
        $author_id = '';
        $id = '';
        $button = 'Добавить шутку';

        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try{
            $result = $pdo->query('SELECT author_id, author_name FROM author');
        }catch (PDOException $e){
            $error = 'Ошибка извлечения имени автора' . $e->getMessage();
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
            $error = 'Ошибка извлечения имени автора' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        foreach ($result as $row){
            $categories[] = array('id' => $row['id'], 'name' => $row['category_name'], 'selected' => false);
        }

        include 'form.html.php';
        exit();
    }
    // ============================ Блок редактирования шуток =================
    if(isset($_POST['action']) and $_POST['action'] == 'Редактировать'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try{
            $sql = 'SELECT id, joketext, author_id FROM jokes WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch (PDOException $e) {
            $error = 'Ошибка извлечения имени шуток автора' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        $row = $s->fetch();
        $pageTitle = 'Редактировать шутку';
        $action = 'editform';
        $text = $row['joketext'];
        $puthorid = $row['author_id'];
        $id = $row['id'];
        $button = 'Обновить шутку';

        //Формируем список всех авторов
        try{
            $result = $pdo->query('SELECT author_id, author_name FROM author');
        }catch (PDOException $e){
            $error = 'Ошибка извлечения имени автора' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        foreach ($result as $row){
            $authors[] = array('id' => $row['author_id'], 'name' => $row['author_name']);
        }

        // Формируем список категорий выбранной шутки
        try{
            $sql = 'SELECT category_id FROM joke_category WHERE joke_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка извлечения категорий выбранной шутки' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        foreach ($s as $row){
            $selectedCategories[] = $row['category_id'];
        }
echo $selectedCategories;
        // Формируем список всех категорий
        try{
            $result = $pdo->query('SELECT id, category_name FROM category');
        }catch (PDOException $e){
            $error = 'Ошибка извлечения категорий' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        foreach ($result as $row){
            $categories[] = array(
                'id' => $row['id'],
                'name' => $row['category_name'],
                'selcted' => in_array($row['id'], $selectedCategories));
        }

        include 'form.html.php';
        exit();
    }

    // ============================ Блок интеграции ===========================
    if(isset($_GET['action']) && $_GET['action'] == 'search'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        // Базовое выражение SELECT
        $select = 'SELECT id, joketext';
        $from   = ' FROM jokes';
        $where  = ' WHERE TRUE';

        $placeholders = array();
        if($_GET['author'] != ''){ // Автор выбран
            $where .= ' AND author_id = :author_id'; // from "jokes"-table
            $placeholders[':author_id'] = $_GET['author']; // <- <select name="author"><option value="$author['id']">
            // 'SELECT id, joketext FROM jokes WHERE TRUE AND author_id = :author_id'
        }

        if($_GET['category']){// Категория выбрана
            $from .= ' INNER JOIN joke_category ON id = joke_id';
            $where .= ' AND category_id = :category_id';
            $placeholders[':category_id'] = $_GET['category']; // $placeholders = array(:author_id, :category_id);
            // SELECT id, joketext FROM jokes INNER JOIN joke_categoty WHERE TRUE AND categot_id = :category_id);
        }

        if($_GET['text'] != ''){
            $where .= ' AND joketext LIKE :joke_text';
            $placeholders[':joke_text'] = '%' . $_GET['text'] . '%'; // $placeholders = array(:author_id, :category_id, :joke_text);
            /* SELECT id, joketext
                FROM jokes
                INNER JOIN joke_categoty ON id = joke_id
                WHERE TRUE
                    AND categot_id = :category_id
                    AND joketext   LIKE :joke_text);
            */
        }

        // Формируем и выводим шутки
        try{
            $sql = $select . $from . $where;
            $s = $pdo->prepare($sql);
            $s->execute($placeholders);
        }catch(PDOException $e){
            $error = 'Ошибка извлечения и вывода выбранных шуток' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        foreach($s as $row){
            $jokes[] = array('id' => $row['id'], 'text' => $row['joketext']);
        }

        include 'jokes.html.php';
        exit();
    }

    // ============================= A SEARCH FORM =================================

    // Выводим форму поиска
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    // Получаем автров
    try{
        $result = $pdo->query('SELECT author_id, author_name FROM author');
    }catch (PDOException $e){
        $error = 'Ошибка извлечения имени автора' . $e->getMessage();
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
        $error = 'Ошибка извлечения категорий' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    foreach ($result as $row){
        $categories[] = array('id' => $row['id'], 'name' => $row['category_name']);
    }

    $pageTitle = 'Управление шутками';
    include 'searchform.html.php';




























