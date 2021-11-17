<?php

namespace coloco\controllers;

use coloco\models\Usermodel;

class UserControllers
{
    public static function getUsers()
    {
        $users = Usermodel::find();
        print_r(json_encode($users));
    }
    public static function createUser()
    {
        $body = json_decode(file_get_contents('php://input', true));
        $users = Usermodel::create($body->username, $body->firstname, $body->lastname, $body->email, $body->password);
        print_r($users);
    }
    public static function getUser()
    {
        extract($_GET);
        $user = UserModel::findById($id);
        print_r($user);
    }
    public static function updateUser()
    {

    }
    public static function deleteUser()
    {
        extract($_GET);
        UserModel::findByIdAndDelete($id);
    }
}