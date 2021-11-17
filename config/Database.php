<?php

namespace coloco\config;

use PDOException;

class Database
{
    private static $host = 'localhost';
    private static $port = 3306;
    private static $dbname = 'coloco';
    private static $username = 'root';
    private static $password = '';
    private static $con;

    public static function connect()
    {
        try {

            $con = new \PDO('mysql:host=' . self::$host . ';port=' . self::$port . ';dbname=' . self::$dbname, self::$username, self::$password);
            $con->setAttribute(\PDO::ERRMODE_EXCEPTION, \PDO::ATTR_ERRMODE);
            // echo 'success';
            return $con;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}