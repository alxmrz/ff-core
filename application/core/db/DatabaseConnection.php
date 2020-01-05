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
            //TODO: remake the way of displaying error
            $error = "Database error!";
            include '/view/error.php';
            exit();
        }
    }

    /**
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
     * @return \PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }

}
