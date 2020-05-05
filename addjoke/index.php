<?php
    if(isset($_GET['addjoke'])){
        include '../includes/access.inc.php';

        if (!userIsLoggedIn()){
            $text = 'В целях безопасности Вы должны авторизоваться:';
            $flag = true;

            include '../admin/login.html.php';
            exit();
        }

        include 'form.html.php';
        exit();
    }

    // Регитрация пользователей как авторов
    if(isset($_GET['registr'])){
        include '../registr.inc.html.php';
        exit();
    }

    // Обработка формы регистрации
    if (isset($_POST['action']) and $_POST['action'] == 'registr'){

        if(!isset($_POST['name']) or $_POST['name'] == '' or
            !isset($_POST['email']) or $_POST['email'] == ''){

        }

        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try{
            $sql = '';
        }catch (PDOException $e) {
            $error = 'Ошибка добавления пользователя' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
    }


    // Выводим шутки
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

    try{
        $sql = "UPDATE jokes SET jokedate = '2012-04-01' " .
            "WHERE joketext LIKE '%цыплёнок%'";
        $effected_rows = $pdo->exec($sql);
    }
    catch(PDOException $e){
        $error = 'Невозможно подключиться к серверу Баз Данных!' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

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


    while ($row = $result->fetch()){
        $jokes[] = array(
            'id' => $row['id'],
            'text' => $row['joketext'],
            'auth_name' => $row['author_name'],
            'auth_email' => $row['author_email']);
    }

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

    $output = 'Соединение с Базой Данных установлено!<br>' .
        'Обновлено ' . $effected_rows . '.<br><hr>';
    include 'output.html.php';

    include 'jokes.html.php';
