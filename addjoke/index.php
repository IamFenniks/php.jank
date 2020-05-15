<?php
    // ========================== Выводим шутки Старт ===================//
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $sql = 'SELECT id, joketext, author_name, author_email ' .
            'FROM jokes INNER JOIN author ' .
            'ON jokes.author_id = author.author_id';
        $result = $pdo->query($sql);
    }catch (PDOException $e){
        $error = 'Ошибка при извлечении шуток' . $e->getMessage();
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

        try{
            $joketext = $_POST['joketext'];

            $sql = 'INSERT INTO jokes SET 
                joketext = :joketext,
                jokedate = CURDATE()';

            $s = $pdo->prepare($sql);
            $s->bindValue(':joketext', $_POST['joketext']);
            $s->execute();
        }
        catch(PDOException $e){
            echo 'Ошибка запроса к БД. Добавление шутки' . $e->getMessage();
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

    include 'jokes.html.php';
