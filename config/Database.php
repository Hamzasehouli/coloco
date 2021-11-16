<?php

namespace coloco\config;

use PDOException;

class Database {
        private $host = 'localhost';
        private $port = 3306;
        private $dbname = 'coloco';
        private $username = 'root';
        private $password = '';
        public $con;

        public function connect(){
            try{
                
                $con = new \PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname", $this->username, $this->password);
                $con->setAttribute(\PDO::ERRMODE_EXCEPTION, \PDO::ATTR_ERRMODE);
                // echo 'success';
                return $con;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
}