<?php

declare(strict_types=1);

namespace coloco\controllers;

use coloco\helpers\GenerateJwt;
use coloco\helpers\ErrorHandler;
use coloco\models\Usermodel;

class AuthControllers
{
    //SIGNUP/////////////////////////////////////////////////////////////////////////////////////////////////7
    //SIGNUP/////////////////////////////////////////////////////////////////////////////////////////////////7
    //SIGNUP/////////////////////////////////////////////////////////////////////////////////////////////////7
    public static function signup()
    {
        $body = json_decode(file_get_contents('php://input', true),true);
        

        if(!$body){
            ErrorHandler::run(statusCode:400, message:'Please fill all the required fields');
        }
        extract($body);

        if(!isset($firstname)||empty(str_replace(' ', '', $firstname))){
                ErrorHandler::run(statusCode:400, message:'Please enter your firstname');
                
        }
        

        if (!isset($lastname)||empty(str_replace(' ', '', $lastname))) {
            ErrorHandler::run(statusCode:400, message:'Please enter your lastname');
            
        }

        if (!isset($username)||empty(str_replace(' ', '', $username)) || strlen(str_replace(' ', '', $username)) < 3) {
            ErrorHandler::run(statusCode:400, message:'Please enter your username');
            
        }

        if (!isset($email)||empty(str_replace(' ', '', $email)) || !str_contains(str_replace(' ', '', $email), '@') || !str_contains(explode('@', str_replace(' ', '', $email))[1], '.')) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid email');
            
        }

        if (!isset($password)||empty(str_replace(' ', '', $password)) || strlen(str_replace(' ', '', $password)) < 8) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid password, password must have at least 8 chars');
            
        }
        $user = Usermodel::create($username, $firstname, $lastname, $email, $password);

        if (!$user) {
            ErrorHandler::run(statusCode:400, message:'You can not signup for this moment, please try again later');
            
        }

        extract($user[0]);

        $gt = new GenerateJwt();
        $jwt = $gt->generateToken($id);
        $_SESSION['token'] = $jwt;
        http_response_code(201);
        echo(json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));

    }

     //ISLOGGEDIN/////////////////////////////////////////////////////////////////////////////////////////////////7
    //ISLOGGEDIN/////////////////////////////////////////////////////////////////////////////////////////////////7
    //ISLOGGEDIN/////////////////////////////////////////////////////////////////////////////////////////////////7

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
        if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {

            http_response_code(200);
            print_r(json_encode(['status' => 'success', 'data' => $user]));
        }

        return $user;

        ///////////////////////////////////////////////////////

    }

     //PROTECT/////////////////////////////////////////////////////////////////////////////////////////////////7
    //PROTECT/////////////////////////////////////////////////////////////////////////////////////////////////7
    //PROTECT/////////////////////////////////////////////////////////////////////////////////////////////////7

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

     //LOGIN/////////////////////////////////////////////////////////////////////////////////////////////////7
    //LOGIN/////////////////////////////////////////////////////////////////////////////////////////////////7
    //LOGIN/////////////////////////////////////////////////////////////////////////////////////////////////7

    public static function login()
    {
        $data = json_decode(file_get_contents('php://input', true));

        if (!isset($data->email)) {
            ErrorHandler::run(statusCode:400, message:'Please enter your email to login');
            exit;
        }
        $body = json_decode(json_encode($data), true);

        $user = Usermodel::findOne(['email' => $body['email']]);
        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'User no longer exists or the credentials are incorrect');
            exit;
        }

        extract($user);
        $isPasswordCorrect = password_verify($data->password, $password);
        if (!$isPasswordCorrect) {
            ErrorHandler::run(statusCode:400, message:'User no longer exists or the credentials are incorrect');
            exit;
        }
        $gt = new GenerateJwt();
        $jwt = $gt->generateToken($id);
        $_SESSION['token'] = $jwt;
        http_response_code(200);
        echo(json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));

    }

     //GETME/////////////////////////////////////////////////////////////////////////////////////////////////7
    //GETME/////////////////////////////////////////////////////////////////////////////////////////////////7
    //GETME/////////////////////////////////////////////////////////////////////////////////////////////////7
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

     //UPDATEME/////////////////////////////////////////////////////////////////////////////////////////////////7
    //UPDATEME/////////////////////////////////////////////////////////////////////////////////////////////////7
    //UPDATEME/////////////////////////////////////////////////////////////////////////////////////////////////7
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

     //DELETEME/////////////////////////////////////////////////////////////////////////////////////////////////7
    //DELETEME/////////////////////////////////////////////////////////////////////////////////////////////////7
    //DELETEME/////////////////////////////////////////////////////////////////////////////////////////////////7
    public static function deleteMe()
    {

        $user = self::isLoggedin();
        if (!$user) {
            return;
        }

    
        UserModel::findByIdAndDelete($user['id']);
        session_destroy();
        http_response_code(204);
        print_r(json_encode(['status' => 'success', 'message' => 'Your account has been deleted successfully']));
    }


     //LOGOUT/////////////////////////////////////////////////////////////////////////////////////////////////7
    //LOGOUT/////////////////////////////////////////////////////////////////////////////////////////////////7
    //LOGOUT/////////////////////////////////////////////////////////////////////////////////////////////////7

    public static function logout()
    {
        session_destroy();
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'You are logged out successfully']));
    }
}