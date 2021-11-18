<?php

namespace coloco\models;

use coloco\config\Database;

$con = Database::connect();

class UserModel
{
    // private $id = '';
    // private $firstname = '';
    // private $lastname = '';
    // private $username = '';
    // private $email = '';
    // private $role = '';
    // private $password = '';
    // private $created_at = '';

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
        
        if(empty(str_replace(' ','',$firstname))){
            header("HTTP/1.1 403");
            print_r(json_encode('Please enter your firstname'));
            return;
        }

        if(empty(str_replace(' ','',$lastname))){
            header("HTTP/1.1 403");
            print_r(json_encode('Please enter a lastname'));
            return;
        }

        if(empty(str_replace(' ','',$username)) || strlen(str_replace(' ','',$username))<3){
            header("HTTP/1.1 403");
            print_r(json_encode('Please enter a username'));
            return;
        }

        if(empty(str_replace(' ','',$email)) || !str_contains(str_replace(' ','',$email), '@') || !str_contains(explode('@',str_replace(' ','',$email))[1],'.')){
            header("HTTP/1.1 403");
            print_r(json_encode('Please enter a valid email'));
            return;
        }

        if(empty(str_replace(' ','',$password)) || strlen(str_replace(' ','',$password))<8){
            header("HTTP/1.1 403");
            print_r(json_encode('Please enter a valid password, password must have at least 8 chars'));
            return;
        }

        $query = 'INSERT INTO user(username, firstname, lastname, email, password) VALUES(:username,:firstname,:lastname,:email,:password)';
        $stmt = $con->prepare($query);
        $hashedPssword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $hashedPssword);
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
    public static function findByIdAndDelete($id)
    {
        global $con;
        $query = 'DELETE FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo 'deleted successully';
        return;

    }
    public static function findByIdAndUpdate($id, $data)
    {   
        
        $keys = array_keys($data);
        global $con;
        $str = implode(',',array_map(function ($d) {
            return "$d=:$d";
        }, $keys));
        $query = 'UPDATE user SET ' . $str . ' WHERE id=:id';
        print_r($query);
        $stmt = $con->prepare($query);
        foreach ($data as $d =>$v):
            $stmt->bindValue(":$d", $v);
        endforeach;
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo 'updated successully';
        return;

    }

}