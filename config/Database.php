<?php

declare (strict_types = 1);

namespace coloco\config;

use coloco\helpers\ErrorHandler;

class Database
{

    public static function connect(): \PDO
    {
        try {

            $con = new \PDO('mysql:host=' . (string) $_ENV['HOST'] . ';port=' . (int) $_ENV['PORT'] . ';dbname=' . (string) $_ENV['DB_NAME'], (string) $_ENV['USERNAME'], (string) $_ENV['PASSWORD'], [\PDO::ATTR_EMULATE_PREPARES => false]);
            return $con;
        } catch (\PDOException$e) {
            ErrorHandler::run(statusCode:500, message:$e->getMessage());
        }
    }
}
