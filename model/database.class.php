<?php
require_once '../config/configuration.php';
class database
{
    protected $dbname='webjob';
    protected $dbuser='root';
    protected $dbpassword='goblin';
    protected $encoding='utf8';
    function __construct()
    {
        try
        {
            $pdo = new PDO ("mysql:host=localhost;dbname=$this->dbname", $this->dbuser, $this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET NAMES $this->encoding");
    
        } 
        catch (PDOException $ex)
        {
            $error = "Database error!";
            include 'error.php';
            exit();
        }
    }
    public function dbQuery($sql)
    {
        
    }
}