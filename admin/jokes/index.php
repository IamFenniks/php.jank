<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 09.04.2020
 * Time: 14:37
 */

// ================( Блок авторизации Редактора сайта )=====================

include $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

if(!userIsLoggedIn()){
    $text = 'Пожалуйста войдите в систему, чтобы редактировать страницу, к которой Вы обратились';
    include '../login.html.php';
    exit();
}

if(!userHasRole('Редактор')){
    $error = 'Доступ к этой странице имеет только "Редактор" сайт';
    include '../accessdenied.html.php';
    exit();
}

// ========================== Блок добавления шуток Start============================= //
    if(isset($_GET['add'])){
        $pageTitle = 'Новая шутка';
        $action = 'addform';
        $label = 'Введите сюда свою шутку:';
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

    // Добавляем в таблицу с шутками новую щутку, указав автора
    if(isset($_GET['addform'])){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        if($_POST['author'] == ''){
            $error = 'Вы не указали автора шутки. Вернитесь назад.';
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        try{
            $sql = 'INSERT INTO jokes SET 
                    joketext = :joketext, 
                    jokedate = CURDATE(), 
                    author_id = :author_id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':joketext', $_POST['text']);
            $s->bindValue(':author_id', $_POST['author']);
            $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка добавления шутки' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        $joke_id = $pdo->lastInsertId();

        // Добавляем в промежуточную таблицу id зачекиненых категорий
        if(isset($_POST['category'])){
            try{
                $sql = 'INSERT INTO joke_category SET 
                        joke_id = :joke_id, 
                        category_id = :category_id';
                $s = $pdo->prepare($sql);

                foreach ($_POST['category'] as $category_id){
                    $s->bindValue(':joke_id', $joke_id);
                    $s->bindValue(':category_id', $category_id);
                    $s->execute();
                }
            }catch (PDOException $e){
                $error = 'Ошибка добавления id шутки в промежуточную таблицу' . $e->getMessage();
                include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
                exit();
            }
        }

        header('Location: .');
        exit();
    }
// ========================== Блок добавления шуток End============================= //

// ============================ Блок редактирования шуток Start====================== //
    // Отправка данных в форму для редактирования
    if(isset($_POST['action']) and $_POST['action'] == 'Редактировать'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try{
            $sql = 'SELECT id, joketext, author_id, visible FROM jokes WHERE id = :id';
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
        $label = 'Редактируйте здесь свою шутку:';
        $text = $row['joketext'];
        $author_id = $row['author_id'];
        $id = $row['id'];
        $visible = $row['visible'];
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

        // Формируем список категорий  к которым относится выбранная шутка
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

        // Формируем список всех категорий
        try{
            $result2 = $pdo->query('SELECT id, category_name FROM category');
        }catch (PDOException $e){
            $error = 'Ошибка извлечения категорий' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        foreach ($result2 as $row){
            $categories[] = array(
                'id' => $row['id'],
                'name' => $row['category_name'],
                'selected' => in_array($row['id'], $selectedCategories));
        }

        // Формируем модерацию
        try{
            $sql = 'SELECT visible FROM jokes WHERE id = :id';
            $result3 = $pdo->prepare($sql);
            $result3->bindValue(':id', $_POST['id']);
            $result3->execute();
        }catch (PDOException $e){
            $error = 'Ошибка извлечения видимости шуток' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }
        $row = $result3->fetch();
        $visibility = $row['visible'];

        include 'form.html.php';
        exit();
    }

    // Получение данных из формы для обработки
    if(isset($_GET['editform'])){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        if($_POST['author'] == ''){
            $error = 'Вы не указали автора шутки. Вернитесь назад.';
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        // Обновляем публикацию ушток
        $visibility = $_POST['visibility'];
        try{
            $sql = "UPDATE jokes SET visible = '$visibility'  WHERE id = :id";
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка добавления измененых шуток' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        // Обновляем данные в таблице с шутками
        try{
            $sql = 'UPDATE jokes SET 
                    joketext = :joke_text, 
                    author_id = :author_id 
                    WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->bindValue(':joke_text', $_POST['text']);
            $s->bindValue(':author_id', $_POST['author']);
            $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка добавления измененых шуток' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        // Удаляем из промежуточной таблицы все записи перед обновлением по-редактируемой шутке
        try{
            $sql = 'DELETE FROM joke_category WHERE joke_id = :joke_id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':joke_id', $_POST['id']);
            $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка удаления записей из промежуточной таблицы по-выбранной шутки' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        // Обновление промежуточной таблицы
        if(isset($_POST['category'])){
            try{
                $sql = 'INSERT INTO joke_category SET 
                        joke_id = :joke_id, 
                        category_id = :category_id';
                $s = $pdo->prepare($sql);

                foreach($_POST['category'] as $category_id){
                    $s->bindValue(':joke_id', $_POST['id']);
                    $s->bindValue(':category_id', $category_id);
                    $s->execute();
                }
            }catch (PDOException $e){
                $error = 'Ошибка добавления в промежуточную таблицу для выбранной шутки' . $e->getMessage();
                include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
                exit();
            }
        }

        header('Location: .');
        exit();
    }
// ============================ Блок редактирования шуток Ebd====================== //


// ============================ Блок удаления шуток Start========================== //
    if(isset($_POST['action']) and $_POST['action'] == 'Удалить'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try{
            $sql = 'DELETE FROM jokes WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка удаления выбранной шутки' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        try{
            $sql = 'DELETE FROM joke_category WHERE  joke_id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка удаления из промежуточной таблицы для выбранной шутки' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        header('Location: .');
        exit();
    }
// ============================ Блок удаления шуток End ========================== //

// ============================ Блок интеграции Start ============================ //
    if(isset($_GET['action']) && $_GET['action'] == 'search'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        // Базовое выражение SELECT
        $select = 'SELECT id, joketext, visible';
        $from   = ' FROM jokes';
        $where  = ' WHERE TRUE';

        if($_GET['visibility'] == 'YES'){
            $where .= " AND visible = 'YES'";
        }
        if($_GET['visibility'] == 'NO'){
            $where .= " AND visible = 'NO'";
        }

        $placeholders = array();
        if($_GET['author'] != ''){ // Автор выбран
            $where .= ' AND author_id = :author_id'; // from "jokes"-table
            $placeholders[':author_id'] = $_GET['author']; // <- <select name="author"><option value="$author['id']">
            // 'SELECT id, joketext FROM jokes WHERE TRUE AND author_id = :author_id'
        }

        if($_GET['category'] != ''){// Категория выбрана
            $from .= ' INNER JOIN joke_category ON id = joke_id';
            $where .= ' AND category_id = :category_id';
            $placeholders[':category_id'] = $_GET['category']; // $placeholders = array(:author_id, :category_id);
            // SELECT id, joketext FROM jokes INNER JOIN joke_categoty WHERE TRUE AND author_id = authorid' AND categot_id = category_id);
            if($placeholders[$_GET['category']] == 0){
                $error = "У автора нет шуток в этой категории";
            }
        }

        if($_GET['text'] != ''){
            $where .= ' AND joketext LIKE :joke_text';
            $placeholders[':joke_text'] = '%' . $_GET['text'] . '%'; // $placeholders = array(:author_id, :category_id, :joke_text);
            /* SELECT id, joketext FROM jokes
                INNER JOIN joke_categoty ON id = joke_id
                WHERE TRUE
                    AND author_id = :author_id
                    AND categot_id = :category_id
                    AND joketext LIKE :joke_text);
            */
            if($placeholders[$_GET['text']] == 0){
                $error = "Ни одна из шуток не соответствует введённой Вами фразе!";
            }
        }

        // Формируем и выводим шутки
        try{
            // $sql =
            $sql = $select . $from . $where;
            $s = $pdo->prepare($sql);
            $s->execute($placeholders);
        }catch(PDOException $e){
            $error = 'Ошибка извлечения и вывода выбранных шуток' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        foreach($s as $row){
            $jokes[] = array('id' => $row['id'], 'text' => $row['joketext'], 'visibility' => $row['visible']);
        }

        include 'jokes.html.php';
        exit();
    }
// ============================ Блок интеграции End ============================ //

// ============================= A SEARCH FORM ================================= //
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

//Получаем видимость шуток
try{
    $result = $pdo->query('SELECT visible FROM jokes');
}catch (PDOException $e){
    $error = 'Ошибка извлечения категорий' . $e->getMessage();
    include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
    exit();
}

foreach ($result as $row){
    $visibility[] = $row['visible'];
}

    $pageTitle = 'Управление шутками';
    include 'searchform.html.php';




























