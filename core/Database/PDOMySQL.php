<?php
namespace Core\Database;
use Core\Environment\DotEnv;

class PDOMySQL
{


   public static function getPdo(){

       $dotEnv = new DotEnv();


        $dbHost = $dotEnv->getVariable("DBHOST");
        $dbName = $dotEnv->getVariable("DBNAME");

        $username = $dotEnv->getVariable("USERNAME");
        $password = $dotEnv->getVariable("PASSWORD");

        $pdo = new \PDO(
            "mysql:host=$dbHost;dbname=$dbName",
            $username,
            $password,
            [
                \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ
            ]
        );
        return $pdo;
    }




}