<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 20.04.2020
 * Time: 18:46
 */

// Массив с товарами
$items = array(
    array('id' => '1', 'desc' => 'Канадско-австралийский словарь', 'price' => 24.95),
    array('id' => '2', 'desc' => 'Практическ нвый парашют (никогда не открывался)', 'price' => 1000),
    array('id' => '3', 'desc' => 'Песни группы GoldFish (набор из 2-х CD)', 'price' => 19.99),
    array('id' => '4', 'desc' => 'Просто JavaScipt (SitePoint)', 'price' => 39.95)
);

// Старт новой сессии
session_start();

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}
// Обрабатываем кнопку "Купить" со страницы "Каталог товаров"
if(isset($_POST['action']) and $_POST['action'] == "Купить"){
    $_SESSION['cart'][] = $_POST['id'];

    header('Location: .');
    exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Очистить корзину'){
    // Опустошаем массив $_SESSION['cart']
    unset($_SESSION['cart']);
    header('Location: ?cart');
    exit();
}
// Обработка команды "Посмотреть корзину"
if (isset($_GET['cart'])){
    $cart = array();
    $total = 0;

    foreach ($_SESSION['cart'] as $id){
        foreach ($items as $product){
            if($product['id'] == $id){
                $cart[] = $product;
                $total += $product['price'];
                break;
            }
        }
    }

    include "cart.html.php";
    exit();
}

// Очистка корзины
if (isset($_POST['action']) and $_POST['action'] == 'Отменить'){
    // Опустошаем массив $_SESSION['cart']
    unset($_SESSION['cart'][$_POST['id']-1]);
    header('Location: ?cart');
    exit();
}



// Подключение каталога товаров
include 'catalog.html.php';

























