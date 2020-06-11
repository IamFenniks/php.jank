<?php

    error_reporting();

    // ========================== Выводим шутки Старт ===================//
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = "SELECT id, joketext, author_name, author_email 
                FROM jokes INNER JOIN author 
                ON jokes.author_id = author.author_id 
                WHERE visible = 'YES'";
        $result = $pdo->query($sql);
    }catch (PDOException $e){
        $error = 'Ошибка при извлечении шуток<br>' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    while ($row = $result->fetch()){
        $jokes[] = array(
            'id' => $row['id'],
            'text' => $row['joketext'],
            'auth_name' => $row['author_name'],
            'auth_email' => $row['author_email']);
    }
    // ========================== Выводим шутки Конец ===================//


    // ========================== Добавляем шутки Старт ===================//
    //
    if(isset($_POST['joketext'])){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

        session_start();
        try{
            $sql = 'SELECT * FROM author WHERE author_email = :email AND password = :password';
            $s = $pdo->prepare($sql);
            $s->bindValue(':email', $_SESSION['email']);
            $s->bindValue(':password', $_SESSION['password']);
            $s->execute();
        }catch(PDOException $e){
            $error =  'Ошибка поиска id автора. <br>' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }
        while($row = $s->fetch()){
            $authorId = $row['author_id'];
        }

        // Добавляем новую шутку в БД
        try{
            $joketext = $_POST['joketext'];

            $sql = 'INSERT INTO jokes SET 
            joketext = :joketext,
            author_id = :authorId,
            jokedate = CURDATE()';

            $s = $pdo->prepare($sql);
            $s->bindValue(':joketext', $_POST['joketext']);
            $s->bindValue(':authorId', $authorId);
            $s->execute();
        }
        catch(PDOException $e){
            echo 'Ошибка запроса к БД. Добавление шутки' . $e->getMessage();
            include 'error.html.php';
            exit();
        }

        // Добавляем id новой шутки в промежуточную таблицу
        $jokeID = $pdo->lastInsertId();
        try{
            $sql = 'INSERT INTO joke_category SET 
                    joke_id = :joke_id,
                    category_id = :category_id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':joke_id', $jokeID);
            $s->bindValue(':category_id', 1);
            $s->execute();
        }
        catch(PDOException $e){
            echo 'Ошибка запроса к БД. Добавление id шутки и id категории в joke_category' . $e->getMessage();
            include 'error.html.php';
            exit();
        }

        header('Location: .');
        exit();
    }
    // ========================== Добавляем шутки Конец ===================//


    // ========================== Удаляем шутки Старт ===================//
    if(isset($_GET['delete_joke'])){
        $_SERVER['DOCUMENT_ROOT'] . '/db.inc.php';

        try{
            $sql = 'DELETE FROM jokes WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch(PDOException $e){
            echo 'Ошибка запроса к БД. Удаление шутки' . $e->getMessage();
            include 'error.html.php';
            exit();
        }

        header('Location: .');
        exit();
    }
    // ========================== Удаляем шутки Конец ===================//


    // ========================== Регитсрация Старт ===================//
    // Если сработала кнопка "Добавить собственную шутку"
    if(isset($_GET['addjoke'])){
        include '../includes/access.inc.php';

        if (!userIsLoggedIn()){
            $text = 'В целях безопасности Вы должны авторизоваться:';
            $flag = true; // Указывается если это простой пользователь

            include '../admin/login.html.php';
            exit();
        }


        include 'form.html.php';
        exit();
    }

    // Обработка формы регистрации
    if (isset($_POST['action']) and $_POST['action'] == 'reg_form'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';

        // Проверяем корректность ввода данных и не существует ли уже похожий автор
        if(!userRegistration()){
            $text = 'Ошибка ввода даннх';
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/register.inc.html.php';
            exit();
        }

        $name = $_POST['name'];
        $pass = md5($_POST['password1'] . 'ijdb');
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        try{
           $sql = 'INSERT INTO author SET 
                  author_name = :name, 
                  author_email = :email,
                  password = :password';
           $s = $pdo->prepare($sql);
           $s->bindValue(':name', $name);
           $s->bindValue(':email', $_POST['email']);
           $s->bindValue(':password', $pass);
           $s->execute();
        }catch (PDOException $e){
            $error = 'Ошибка добавления вновь зарегин пользователя в БД<br>' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        $text = "Поздравляем Вас, $name! Вы успешно зарегистрировались.";
        $flag = false;
        include $_SERVER['DOCUMENT_ROOT'] . '/admin/login.html.php';
        exit();
    }
    if(isset($_POST['action']) and $_POST['action'] == 'login'){
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';
        if(!userIsLoggedIn()){
            $text = 'Ошибка ввода даннх';
            $flag = true;
            include $_SERVER['DOCUMENT_ROOT'] . '/admin/login.html.php';
            exit();
        }
    }

    if(isset($_GET['to_reg'])){
        $text = 'Заполните все поля данной формы';
        include 'register.inc.html.php';
        exit();
    }
    // Регитрация пользователей как авторов
    // ========================== Регитсрация Конец ===================//


    // ========================== Голосование Старт ===================//
    if(isset($_POST['voting'])){
        require $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
        $ip_key = getIP();

        require $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
        try{
            $sql = $pdo->query('SELECT * FROM userIP');
        }catch (PDOException $e){
            $error = 'Ошибка извлечения IP_KEY<br>' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }

        while ($row = $sql->fetch()){
            $result[] = array('ip'=> $row['ip'], 'key' => $row['key']);
            if($result == $ip_key){
                $error = 'Извините, но Вы уже отдавали голос за эту уштку';
                include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
                exit();
            }
        }

        try{
            $sql = 'INSERT INTO userIP(ip, key) 
                    VALUES ($ip)';
        }catch (PDOException $e){
            $error = 'Ошибка добавления IP_KEY<br>' . $e->getMessage();
            include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
            exit();
        }
    }
    // ========================== Голосование Конец ===================//

    include 'jokes.html.php';
