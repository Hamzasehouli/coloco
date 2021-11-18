<?php

namespace coloco\controllers;

use coloco\models\Usermodel;
use coloco\helpers\GenerateJwt;

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
        if(!isset($user))return;
        extract($user[0]);
        $gt = new GenerateJwt();
        $jwt = $gt->generateToken($id);
        $_SESSION['token'] = $jwt;
        http_response_code(201);
        print_r(json_encode(['status'=>'success', 'data'=>['user' =>$user, 'token'=>$jwt]]));
    
    }
    public static function isLoggedin()
    {
        $body = json_decode(file_get_contents('php://input', true));
        $user = Usermodel::create($body->username, $body->firstname, $body->lastname, $body->email, $body->password);
        if(!isset($user))return;
        http_response_code(201);
        print_r(json_encode(['status'=>'success', 'data'=>$user]));
    
    }
    public static function protect()
    {
        $body = json_decode(file_get_contents('php://input', true));
        $user = Usermodel::create($body->username, $body->firstname, $body->lastname, $body->email, $body->password);
        if(!isset($user))return;
        http_response_code(201);
        print_r(json_encode(['status'=>'success', 'data'=>$user]));
    
    }
    public static function login()
    {
        $body = json_decode(file_get_contents('php://input', true));
        $user = Usermodel::create($body->username, $body->firstname, $body->lastname, $body->email, $body->password);
        if(!isset($user))return;
        http_response_code(201);
        print_r(json_encode(['status'=>'success', 'data'=>$user]));
    
    }
    public static function getMe()
    {
        extract($_GET);
        if(!isset($id)){
            http_response_code(403);
            print_r(json_encode(['status'=>'fail', 'message'=>'Id of the user is missing']));
        return;
        }
        $user = UserModel::findById($id);
        if(!isset($user))return ;
        http_response_code(200);
        print_r(json_encode(['status'=>'success', 'data'=>$user]));
    }
    public static function updateMe()
    {   
        $body = json_decode(json_encode(json_decode(file_get_contents('php://input', true))),true);
        extract($_GET);
        if(!isset($id)){
            http_response_code(403);
            print_r(json_encode(['status'=>'fail', 'message'=>'Id of the user is missing']));
        return;
        }
        if(!isset($body)){
            http_response_code(403);
            print_r(json_encode(['status'=>'fail', 'message'=>'No input ahs been entered']));
        return;
        }
        UserModel::findByIdAndUpdate($id, $body);
    }
    public static function deleteMe()
    {   
        extract($_GET);
        if(!isset($id)){
            http_response_code(403);
            print_r(json_encode(['status'=>'fail', 'message'=>'Id of the user is missing']));
        return;
        }
        UserModel::findByIdAndDelete($id);
    }
}