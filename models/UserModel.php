<?php

use coloco\config\Database;

$con = Database::connect();

class UserModel
{
    private $id = '';
    private $firstname = '';
    private $lastname = '';
    private $username = '';
    private $email = '';
    private $role = '';
    private $password = '';
    private $created_at = '';

    public function find()
    {
        global $con;
        $query = 'SELECT * FROM user';
        $stmt = $con->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    public function create()
    {
        global $con;
        $query = 'INSERT INTO user() VALUES(:username,:firstname,:lastname,:email,:password)';
        $stmt = $con->prepare($query);
        return $stmt;
    }
    public function findOne()
    {
        global $con;
        $query = 'SELECT * FROM user WHERE email=:email';
        $stmt = $con->prepare($query);
        return $stmt;
    }
    public function findById()
    {
        global $con;
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        return $stmt;
    }
    // public function findByIdAndDelete()
    // {
    // global $con;

    // }
    // public function findByIdAndUpdate()
    // {
    // global $con;

    // }

}