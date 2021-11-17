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

        print_r($body);
        $users = Usermodel::create($body->username, $body->firstname, $body->lastname, $body->email, $body->password);
        print_r($users);
    }
    public static function getUser()
    {
        echo 'get users';
    }
    public static function updateUser()
    {
        echo 'get users';
    }
    public static function deleteUser()
    {
        echo 'get users';
    }
}