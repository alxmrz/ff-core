<?php

try{
    $pdo = new PDO ('mysql:host=localhost;dbname=webjob','root','goblin');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
    
} catch (PDOException $ex) {
    $output= "Нет возможности подключиться к базе данных!";
    include 'error.php';
    exit();
}
