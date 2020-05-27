<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 21.05.2020
 * Time: 13:52
 */

// Создание автоматического backUp-а
include 'functions.inc.php';

$tables = get_tables();
get_dump($tables);

include 'dump.html.php';