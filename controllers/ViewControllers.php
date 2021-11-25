<?php

namespace coloco\controllers;

use coloco\controllers\AuthControllers;

class ViewControllers
{
    public static function overview()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/overview.php';
    }
    public static function profile()
    {

        $res = AuthControllers::isLoggedin();
        // print_r($res);
        if (empty($res['id'])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';

            exit;
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/profile.php';

    }
    public static function ads()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/ad.php';
    }
    public static function ad()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/overview.php';
    }
    public static function signup()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/signup.php';
    }
    public static function login()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
    }
}