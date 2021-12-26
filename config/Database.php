<?php

declare(strict_types=1);

namespace coloco\config;

use PDOException;

class Database
{
    private static $con;

    public static function connect()
    {
        try {

            $con = new \PDO('mysql:host=' . (string)$_ENV['HOST'] . ';port=' . (int)$_ENV['PORT'] . ';dbname=' . (string)$_ENV['DB_NAME'], (string)$_ENV['USERNAME'], (string)$_ENV['PASSWORD']);
            $con->setAttribute(\PDO::ERRMODE_EXCEPTION, \PDO::ATTR_ERRMODE);
            return $con;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}