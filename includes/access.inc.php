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
            $GLOBALS['loginError'] = 'Указан неверный адре электронной почты или пароль';
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
                WHERE author_email = :email AND role.id = :roleid";
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->bindValue(':roleid', $role);
        $s->execute();
    }catch (PDOException $e){
        $error = 'Ошибка при поиске ролей, назначенных автору.';
        include '../addjoke/error.html.php';
        exit();
    }

    $row = $s->fetch();
    if($row[0] > 0){
        return true;
    }else{
        return false;
    }
}