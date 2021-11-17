<?php

namespace coloco\models;

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

    public static function find()
    {
        global $con;
        $query = 'SELECT * FROM user';
        $stmt = $con->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
    public static function create($username, $firstname, $lastname, $email, $password)
    {
        global $con;
        $query = 'INSERT INTO user(username, firstname, lastname, email, password) VALUES(:username,:firstname,:lastname,:email,:password)';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
        $stmt1 = $con->prepare("SELECT * FROM user WHERE email=:email");
        $stmt1->bindValue(':email', $email);
        $stmt1->execute();
        $results = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
    public static function findOne(...$data)
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

    public static function findById($id)
    {
        global $con;
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }
    // public static function findByIdAndDelete()
    // {
    // global $con;

    // }
    // public static function findByIdAndUpdate()
    // {
    // global $con;

    // }

}