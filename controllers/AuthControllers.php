<?php

declare(strict_types=1);

namespace coloco\controllers;

use coloco\helpers\GenerateJwt;
use coloco\models\Usermodel;

class AuthControllers
{
    // public static function getUsers()
    // {
    //     $users = Usermodel::find();
    //     if(!isset($users))return;
    //     http_response_code(200);
    //     print_r(json_encode(['status'=>'success','results'=>count($users), 'data'=>$users]));
    // }
    public static function signup()
    {
        $body = json_decode(file_get_contents('php://input', true));
        $user = Usermodel::create($body->username, $body->firstname, $body->lastname, $body->email, $body->password);
        if (!isset($user)) {
            return;
        }

        extract($user[0]);
        $gt = new GenerateJwt();
        $jwt = $gt->generateToken($id);
        $_SESSION['token'] = $jwt;
        http_response_code(201);
        print_r(json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));

    }

    public static function isLoggedin()
    {

        if (sizeof($_SESSION) === 0) {
            http_response_code(400);
            print_r(json_encode(['status' => 'fail', 'message' => 'Access denied, Please login to continue']));
            exit;
            return;
        }
        extract($_SESSION);
        $jwt = $token;

        $decoded = GenerateJwt::verifyToken($jwt);
        if (!$decoded['istokenValid']) {
            http_response_code(400);
            session_destroy();
            print_r(json_encode(['status' => 'fail', 'message' => 'Login session is expired, please login again to contine']));
            exit;
        }

        $user = UserModel::findById($decoded['userId']);
        if (!isset($user)) {
            return;
        }

        // $_REQUEST['user']= $user;

        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'data' => $user]));

        return $user;

        ///////////////////////////////////////////////////////

    }

    public static function protect()
    {
        $user = self::isLoggedin();
        if (!$user) {
            return;
        }

        if ($user['role'] !== 'admin') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Permission denied']));
            exit;
        }
    }

    public static function login()
    {
        $data = json_decode(file_get_contents('php://input', true));

        if (!$data->email) {
            http_response_code(400);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter your email to login']));
            return;
        }
        $body = json_decode(json_encode($data), true);

        $user = Usermodel::findOne(['email' => $body['email']]);
        if (!isset($user)) {
            return;
        }

        extract($user);
        $isPasswordCorrect = password_verify($data->password, $password);
        if (!$isPasswordCorrect) {
            http_response_code(400);
            print_r(json_encode(['status' => 'fail', 'message' => 'User not found or the password is incorrect']));
            return;
        }
        $gt = new GenerateJwt();
        $jwt = $gt->generateToken($id);
        $_SESSION['token'] = $jwt;
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));

    }
    public static function getMe()
    {
        // extract($_GET);
        // if(!isset($id)){
        //     http_response_code(403);
        //     print_r(json_encode(['status'=>'fail', 'message'=>'Id of the user is missing']));
        // return;
        // }
        // $user = UserModel::findById($id);
        // if(!isset($user))return ;
        $user = self::isLoggedin();
        if (!$user) {
            return;
        }

        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'data' => $user]));
    }
    public static function updateMe()
    {$user = self::isLoggedin();
        if (!$user) {
            return;
        }

        $body = json_decode(json_encode(json_decode(file_get_contents('php://input', true))), true);
        // extract($_GET);
        // if(!isset($id)){
        //     http_response_code(403);
        //     print_r(json_encode(['status'=>'fail', 'message'=>'Id of the user is missing']));
        // return;
        // }
        if (!isset($body)) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'No input ahs been entered']));
            return;
        }
        UserModel::findByIdAndUpdate($user['id'], $body);
    }
    public static function deleteMe()
    {

        $user = self::isLoggedin();
        if (!$user) {
            return;
        }

        // extract($_GET);
        // if(!isset($id)){
        //     http_response_code(403);
        //     print_r(json_encode(['status'=>'fail', 'message'=>'Id of the user is missing']));
        // return;
        // }
        UserModel::findByIdAndDelete($user['id']);
        session_destroy();
        http_response_code(204);
        print_r(json_encode(['status' => 'success', 'message' => 'Your account has been deleted successfully']));
    }

    public static function logout()
    {
        session_destroy();
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'You are logged out successfully']));
    }
}