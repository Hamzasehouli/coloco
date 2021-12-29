<?php

declare(strict_types=1);

namespace coloco\models;

use coloco\config\Database;
use coloco\helpers\ErrorHandler;

$con = Database::connect();

class AdModel
{
    //get ads
    public static function find()
    {

        global $con;
        $query = 'SELECT * FROM ad';
        $stmt = $con->prepare($query);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ads found']));
            return;
        }
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
    //create an ad
    public static function create($data)
    {
        extract($data);
        global $con;

        $query = 'INSERT INTO ad(title, city, image,  district, street, house_number, zip, available_from, available_to, size, floor, price,
        deposit, description, elevator, furnished, user) VALUES(:title, :city,:image, :district, :street, :house_number, :zip, :available_from, :available_to, :size, :floor, :price, :deposit, :description, :elevator, :furnished, :user)';
        $stmt = $con->prepare($query);
        foreach ($data as $k => $v):
            $stmt->bindValue(":$k", $v);
        endforeach;

        try{
            $stmt->execute();
            http_response_code(201);
            echo(json_encode(['status' => 'success', 'message' => 'Ad added successfully']));
            
        }catch(PDOException $e){
            echo $e->getMessage();
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
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No user found, or the credentials are incorrect']));
            return;
        }
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public static function findById($id)
    {
        global $con;
        $query = 'SELECT * FROM ad WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ad found with given id']));
            return;
        }
        $ad = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $ad;
    }
    public static function findByIdAndDelete($id, $user)
    {
        global $con;
        $query = 'SELECT * FROM ad WHERE id=:id AND user=:user';
        $stmt1 = $con->prepare($query);
        $stmt1->bindValue(':id', $id);
        $stmt1->bindValue(':user', $user['id']);
        $stmt1->execute();
        $row = $stmt1->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ad found']));
            return;
        }
        //////////////////7
        $query = 'DELETE FROM ad WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        http_response_code(204);
        print_r(json_encode(['status' => 'success', 'message' => 'ad has been deleted successfully']));
        return;

    }
    public static function findByIdAndUpdate($id, $data, $user)
    {

        global $con;
        $query = 'SELECT * FROM ad WHERE id=:id AND user=:user';
        $stmt1 = $con->prepare($query);
        $stmt1->bindValue(':id', $id);
        $stmt1->bindValue(':user', $user['id']);
        $stmt1->execute();
        $row = $stmt1->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ad found']));
            return;
        }
        ////////////////////////
        $keys = array_keys($data);
        $str = implode(',', array_map(function ($d) {
            return "$d=:$d";
        }, $keys));
        $query = 'UPDATE ad SET ' . $str . ' WHERE id=:id';
        $stmt = $con->prepare($query);
        foreach ($data as $d => $v):
            $stmt->bindValue(":$d", $v);
        endforeach;
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'ad has been updated successfully']));
        return;
    }

}