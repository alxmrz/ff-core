<?php

namespace core;

/**
 * Class DatabaseConnection
 * @package core
 */
class DatabaseConnection
{

    protected $pdo;
    private static $self;

    /**
     * DatabaseConnection constructor.
     * @param $config array
     */
    protected function __construct($config)
    {

        try {
            $this->pdo = new \PDO("mysql:host=localhost;dbname={$config['dbname']}", $config['dbuser'], $config['dbpassword']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES {$config['dbencoding']}");
        } catch (PDOException $ex) {
            $error = "Database error!";
            include '/view/error.php';
            exit();
        }
    }

    /**
     * Возвращает экземпляр класса DatabaseConnection
     * @param $config
     * @return databaseConnection
     */
    public static function getInstance($config)
    {
        if (!isset(self::$self)) {
            self::$self = new self($config);
        }
        return self::$self;
    }

    /**
     * Возвращает экземпляр PDO
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

}
