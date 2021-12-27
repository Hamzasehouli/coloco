<?php
declare(strict_types=1);

namespace coloco\models;

use coloco\config\Database;
use coloco\helpers\ErrorHandler;

$con = Database::connect();

class UserModel
{
    
    public static function find()
    {

        global $con;
        $query = 'SELECT * FROM user';
        $stmt = $con->prepare($query);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            ErrorHandler::run(statusCode:404, message:'No users found'); 
            exit;
        }
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
    

    public static function create($username, $firstname, $lastname, $email, $password)
    {
        
        try{
        global $con;
        
        $query = 'INSERT INTO user(username, firstname, lastname, email, password) VALUES(:username,:firstname,:lastname,:email,:password)';
        $stmt = $con->prepare($query);
        $hashedPssword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $hashedPssword);
            
        
        if($stmt->execute()){

            $stmt1 = $con->prepare("SELECT * FROM user WHERE email=:email");
            $stmt1->bindValue(':email', $email);
            $stmt1->execute();
            $user = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            return $user;
        }
        
    }catch(\PDOException $e){
        ErrorHandler::run(statusCode:500, message:$e->getMessage()); 
    }
    }
    public static function findOne($data)
    {
        extract($data);
        $keys = array_keys($data);
        global $con;
        $query = 'SELECT * FROM user WHERE ' . implode(',', array_map(function ($k) {
            return "$k=:$k";
        }, $keys));
        $stmt = $con->prepare($query);
        foreach ($data as $k => $v):
            $stmt->bindValue(":$k", $v);
        endforeach;
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            ErrorHandler::run(statusCode:404, message:'No user found, or the credentials are incorrect');
            exit;
        }
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public static function findById($id)
    {
        global $con;
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            ErrorHandler::run(statusCode:404, message:'No user found');
            exit;
        }
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }
    public static function findByIdAndDelete($id)
    {
        global $con;
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt1 = $con->prepare($query);
        $stmt1->bindValue(':id', $id);
        $stmt1->execute();
        $row = $stmt1->rowCount();
        if ($row < 1) {
            ErrorHandler::run(statusCode:404, message:'No user found');
            exit;
        }
        //////////////////7
        $query = 'DELETE FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        http_response_code(204);
        print_r(json_encode(['status' => 'success', 'message' => 'user has been deleted successfully']));
        return;

    }
    public static function findByIdAndUpdate($id, $data)
    {

        global $con;
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt1 = $con->prepare($query);
        $stmt1->bindValue(':id', $id);
        $stmt1->execute();
        $row = $stmt1->rowCount();
        if ($row < 1) {
            ErrorHandler::run(statusCode:404, message:'No user found');
            exit;
        }
        ////////////////////////
        $keys = array_keys($data);
        $str = implode(',', array_map(function ($d) {
            return "$d=:$d";
        }, $keys));
        $query = 'UPDATE user SET ' . $str . ' WHERE id=:id';
        $stmt = $con->prepare($query);
        foreach ($data as $d => $v):
            $stmt->bindValue(":$d", $v);
        endforeach;
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'user has been updated successfully']));
        return;
    }

}