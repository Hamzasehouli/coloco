<?php

namespace coloco\config;

use PDOException;

class Database
{
    private static $con;

    public static function connect()
    {
        try {

            $con = new \PDO('mysql:host=' . $_ENV['HOST'] . ';port=' . $_ENV['PORT'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
            $con->setAttribute(\PDO::ERRMODE_EXCEPTION, \PDO::ATTR_ERRMODE);
            // echo 'success';
            return $con;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}