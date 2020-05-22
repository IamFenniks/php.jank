<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 21.05.2020
 * Time: 13:53
 */

//  ----------- Создание автоматического beckUp-a start  -------------------- //
function get_tables(){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try{
        $result = $pdo->query('SHOW TABLES');
    }catch (PDOException $e){
        $error = 'Ошибка соединения. Показать все таблицы. <br>' . $e->getMessage();
        return $error;
        include '../addjoke/error.html.php';
        exit();
    }

    $tables = array();
    foreach ($result as $row){
        $tables[] = $row[0];
    }

    return $tables;
}

function get_dump($tables){
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    if(is_array($tables)){
        $fp = fopen(__DIR__ . '/sql/' . time() . '_dump.sql', 'w');

        // Информационный вводный блок в .sql - файл
$text = '-- SQL Dump 
-- my_version: 0.1
-- 
-- База данных: `ijdb`
-- 
-- ------------------------
-- ------------------------
';
        fwrite($fp, $text);

        foreach ($tables as $item){
            $text .= "
--
-- Структура таблицы: ".$item."
--
            ";
            fwrite($fp, $text);
            $text = ''; // Обнуляем переменную
            $text .= 'DROP TABLE IF EXISTS `' . $item . '`;'; // Удаляем все таблицы

            try{
                $sql = 'SHOW CREATE TABLE ' . $item; // Вновь создаем таблицы
                $result = $pdo->query($sql);
            }catch (PDOException $e){
                $error = 'Ошибка соединения с БД. Показ создания таблиц<br>' . $e->getMessage();
                include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
                exit();
            }
            $row = $result->fetch(); // Array([0] => `table`, [1] => `CREATE TABLE table...`

            $text .= "\n" . $row[1] . ";\n";
            fwrite($fp, $text);

            // Добавляем данные в эти твблицы
            $text = '';
            $text .= "
--
-- Dump DB - table: ".$item."
--
            ";
            $text .= "\nINSERT INTO `" . $item . "` VALUES";
            fwrite($fp, $text);

            try{
                $sql2 = 'SELECT * FROM ' . $item; // Вновь создаем таблицы
                $result2 = $pdo->query($sql2);
            }catch (PDOException $e){
                $error = 'Ошибка соединения с БД. Выборка всего содержимого из таблиц.<br>' . $e->getMessage();
                include $_SERVER['DOCUMENT_ROOT'] . '/addjoke/error.html.php';
                exit();
            }
            $text = "";
            for($i = 0; $i < $result2->rowCount(); $i++){
                $row = $result2->fetch(PDO::FETCH_NUM);

                if($i == 0) $text .= "(";
                else $text .= ",(";

                foreach ($row as $v){
                    $text .= "\"" . $v . "\",";
                }
                $text = rtrim($text, ",");
                $text .= ") ";

                if($i > FOR_WRITE){
                    fwrite($fp, $text);
                    $text = '';
                }
            }
            $text .= ";\n";
            fwrite($fp, $text);
        }
    }
    fclose($fp);
}
//  ----------- Создание автоматического beckUp-a start  -------------------- //
