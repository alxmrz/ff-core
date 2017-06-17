<?php
namespace core;

class DatabaseConnection
{

    protected $dbname = 'i98535xh_webjob';
    protected $dbuser = 'i98535xh_webjob';
    protected $dbpassword = 'goblin';
    protected $encoding = 'utf8';
    protected $pdo;
    private $self;

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
        if(!isset(self::$self)) {
            return new \core\databaseConnection();
        }
        return self::$self;

    }
    public function getPDO() {
        return $this->pdo;
    }


}
