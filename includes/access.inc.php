<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 29.04.2020
 * Time: 11:35
 */


function userIsLoggedIn(){
    if(isset($_POST['action']) and $_POST['action'] == 'login'){
        if(!isset($_POST['email']) or $_POST['email'] == '' or
            !isset($_POST['password']) or $_POST['password'] == ''){
            $GLOBALS['loginError'] = 'Пожалуйста заполните поля формы';
            return false;
        }

        $password = md5($_POST['password'] . 'ijdb');
        if(databaseContainsAuthor($_POST['email'], $password)){
            session_start();
            $_SESSION['logedIn'] = true;
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['password'] = $password;
            return true;
        }else{
            session_start();
            unset($_SESSION['logedIn']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            $GLOBALS['loginError'] = 'Указан неверный адрес электронной почты или пароль';
            return false;
        }
    }

    if(isset($_POST['action']) and $_POST['action'] == 'logout'){
        session_start();
        unset($_SESSION['logedIn']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ' . $_POST['goto']);
        exit();
    }

    session_start();
    if(isset($_SESSION['logedIn'])){
        return databaseContainsAuthor($_SESSION['email'], $_SESSION['password']);
    }
}

function databaseContainsAuthor($email, $password){
    include 'db.inc.php';

    try
    {
        $sql = 'SELECT COUNT(*) FROM author WHERE author_email = :email AND password = :password';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $email);
        $s->bindValue(':password', $password);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $error =  'Ошибка поиска автора. <br>' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    $row = $s->fetch();
    if($row[0] > 0) return true;
    else return false;
}

function userHasRole($role){
    include 'db.inc.php';

    try{
        $sql = "SELECT COUNT(*) FROM author 
                INNER JOIN author_role ON author.author_id = author_role.author_id 
                INNER JOIN role ON role_id = id 
                WHERE author_email = :email AND id = :roleId";
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->bindValue(':roleId', $role);
        $s->execute();
    }catch (PDOException $e){
        $error = 'Ошибка при поиске ролей, назначенных автору.' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
        exit();
    }

    $row = $s->fetch();
    if($row[0] > 0) return true;
    else return false;
}

function userRegistration(){
    if(isset($_POST['name']) and $_POST['name'] == ''){
        $GLOBALS['nameError'] = 'Вы не ввели своё имя';
        return false;
    }
    elseif(isset($_POST['email']) and $_POST['email'] == ''){
        $GLOBALS['emailError'] = 'Вы не ввели имя Вашей електронной почты';
        return false;
    }
    if(isset($_POST['password1']) and $_POST['password1'] == ''){
        $GLOBALS['password1Error'] = 'Вы не ввели Пароль';
        return false;
        exit();
    }
    elseif(isset($_POST['password2']) and $_POST['password2'] == ''){
        $GLOBALS['password2Error'] = 'Вы не подтвердили Пароль';
        return false;
        exit();
    }
    elseif(isset($_POST['password1']) and isset($_POST['password2']) and $_POST['password1'] != $_POST['password2']){
        $GLOBALS['passError'] = 'Пароли не совпадают';
        return false;
        exit();
    }

    return true;
}
