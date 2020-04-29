<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 29.04.2020
 * Time: 11:35
 */

function userIsLoginIn(){
    if(isset($_POST['action']) and $_POST['action'] == 'login'){
        if(!isset($_POST['email']) or $_POST['email'] == '' or
            !isset($_POST['password']) or $_POST['password'] == ''){
            $GLOBALS['loginError'] = 'Пожалуйста заполните поля формы';
            return false;
        }

        $password = md5($_POST['password']);
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
        header('Location:' . $_POST['goto']);
        exit();
    }

    session_start();
    if(isset($_SESSION['logedIn'])){
        return databaseContainsAuthor($_SESSION['email'], $_SESSION['password']);
    }
}

function databaseContainsAuthor($email, $password){
    include 'db.inc.php';

    try{
        $sql = 'SELECT COUNT(*) FROM author 
                WHERE email = :email 
                AND password = :password';
        $s = $pdo->prepare($sql);
        $s->bindValue(':email', $email);
        $s->bindValue(':password', $password);
        $s->execute();
    }catch(PDOException $e){
        $error =  'Ошибка поиска автора. <br>' . $e->getMessage();
        include "../addjoke/error.html.php";
        exit();
    }

    $row = $s->fetch();
    if($row[0] > 0) return true;
    else return false;
}