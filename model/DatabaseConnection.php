<?php
namespace model\DatabaseConnection;
require_once '../config/configuration.php';
class DatabaseConnection
{
    protected $dbname='webjob';
    protected $dbuser='root';
    protected $dbpassword='goblin';
    protected $encoding='utf8';
    protected $pdo;
    function __construct()
    {
        try
        { 
            $this->pdo = new PDO ("mysql:host=localhost;dbname=$this->dbname", $this->dbuser, $this->dbpassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES $this->encoding");
    
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
      return $this->pdo->exec();  
    }
}