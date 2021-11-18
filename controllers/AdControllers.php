<?php

namespace coloco\controllers;

use coloco\models\Usermodel;

class AdControllers
{
    public static function getAds()
    {
        $users = Usermodel::find();
        if(!isset($users))return;
        http_response_code(200);
        print_r(json_encode(['status'=>'success','results'=>count($users), 'data'=>$users]));
    }
    public static function createAd()
    {
        $body = json_decode(file_get_contents('php://input', true));
        $user = Usermodel::create($body->username, $body->firstname, $body->lastname, $body->email, $body->password);
        if(!isset($user))return;
        http_response_code(201);
        print_r(json_encode(['status'=>'success', 'data'=>$user]));
    
    }
    public static function getAd()
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
    public static function updateAd()
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
    public static function deleteAd()
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