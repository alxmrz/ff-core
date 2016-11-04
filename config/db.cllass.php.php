<?php
class dbConnector
{
    private $dbname='webjob';
    private $dbuser='root';
    private $dbpassword='goblin';
    function __construct()
    {
        try
        {
            $pdo = new PDO ("mysql:host=localhost;dbname=localhost","$this->dbuser","$this->dbpassword");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');   
        } 
        catch (PDOException $ex) 
        {
            $errorMessage= "Нет возможности подключиться к базе данных!";
            include 'error.php';
            exit();
        }
    }
}           
            
            
        
