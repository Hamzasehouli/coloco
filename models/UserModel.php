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
    public function create($username, $firstname, $lastname, $email, $password)
    {
        global $con;
        $query = 'INSERT INTO user() VALUES(:username,:firstname,:lastname,:email,:password)';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        return $stmt;
    }
    public function findOne(...$data)
    {
        extract($data);
        global $con;
        $query = 'SELECT * FROM user WHERE' . array_map(function ($d) {
            return "$d:$d";
        }, $data);
        $stmt = $con->prepare($query);
        foreach ($data as $d):
            $stmt->bindValue(":$d", $d);
        endforeach;
        $stmt->execute();
        return $stmt;
    }

    public function findById($id)
    {
        global $con;
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
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