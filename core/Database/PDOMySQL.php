<?php
namespace Core\Database;
use Core\Environment\DotEnv;

class PDOMySQL
{
    public static $currentPdo = null;

    public static function getPdo(){

        $dotEnv = new DotEnv();

        $dbHost = $dotEnv->getVariable("DBHOST");
        $dbName = $dotEnv->getVariable("DBNAME");

        $username = $dotEnv->getVariable("USERNAME");
        $password = $dotEnv->getVariable("PASSWORD");

        if(self::$currentPdo == null){
            self::$currentPdo = new \PDO(
                "mysql:host=$dbHost;dbname=$dbName",
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC
                ]
            );
        }
        return self::$currentPdo;
    }
}