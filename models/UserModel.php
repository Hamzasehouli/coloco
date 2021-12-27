<?php
declare(strict_types=1);

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
        $row = $stmt->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No users found']));
            return;
        }
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
    public static function create($username, $firstname, $lastname, $email, $password)
    {
        global $con;

        if (empty(str_replace(' ', '', $firstname))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter your firstname']));
            return;
        }

        if (empty(str_replace(' ', '', $lastname))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter your lastname']));
            return;
        }

        if (empty(str_replace(' ', '', $username)) || strlen(str_replace(' ', '', $username)) < 3) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter a valid username']));
            return;
        }

        if (empty(str_replace(' ', '', $email)) || !str_contains(str_replace(' ', '', $email), '@') || !str_contains(explode('@', str_replace(' ', '', $email))[1], '.')) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter a valid email']));

            return;
        }

        if (empty(str_replace(' ', '', $password)) || strlen(str_replace(' ', '', $password)) < 8) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter a valid password, password must have at least 8 chars']));
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
        if ($stmt->execute()) {
            $stmt1 = $con->prepare("SELECT * FROM user WHERE email=:email");
            $stmt1->bindValue(':email', $email);
            $stmt1->execute();
            $user = $stmt1->fetchAll(\PDO::FETCH_ASSOC);
            return $user;
        } else {
            http_response_code(500);
            print_r(json_encode(['status' => 'fail', 'message' => 'Something went wrong']));
            return;
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
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No user found']));
            return;
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
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No user found']));
            return;
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
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No user found']));
            return;
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