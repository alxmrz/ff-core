<?php
namespace core;

class DatabaseConnection
{

    protected $dbname = 'webjob';
    protected $dbuser = 'root';
    protected $dbpassword = 'goblin';
    protected $encoding = 'utf8';
    protected $pdo;

    protected function __construct()
    {
        try {
            $this->pdo = new \PDO("mysql:host=localhost;dbname=$this->dbname", $this->dbuser, $this->dbpassword);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES $this->encoding");
        } catch (PDOException $ex) {
            $error = "Database error!";
            include '/view/error.php';
            exit();
        }
    }
    public static function getInstance() {
        if(!isset($self->pdo)) {
            return new \core\databaseConnection();
        }
        return $this->pdo;
    }
    public function getPDO() {
        return $this->pdo;
    }


}
