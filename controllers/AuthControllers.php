<?php

declare (strict_types = 1);

namespace coloco\controllers;

use coloco\helpers\ErrorHandler;
use coloco\helpers\GenerateJwt;
use coloco\helpers\SendEmail;
use coloco\models\Usermodel;

class AuthControllers
{
    //SIGNUP////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //SIGNUP////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //SIGNUP////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function signup()
    {

        $body = json_decode(file_get_contents('php://input', true), true);

        if (!$body) {
            ErrorHandler::run(statusCode:400, message:'Please fill all the required fields');
        }
        extract($body);

        if (!isset($firstname) || empty(str_replace(' ', '', $firstname))) {
            ErrorHandler::run(statusCode:400, message:'Please enter your firstname');

        }

        if (!isset($lastname) || empty(str_replace(' ', '', $lastname))) {
            ErrorHandler::run(statusCode:400, message:'Please enter your lastname');

        }

        if (!isset($username) || empty(str_replace(' ', '', $username)) || strlen(str_replace(' ', '', $username)) < 3) {
            ErrorHandler::run(statusCode:400, message:'Please enter your username');

        }

        if (!isset($email) || empty(str_replace(' ', '', $email)) || !str_contains(str_replace(' ', '', $email), '@') || !str_contains(explode('@', str_replace(' ', '', $email))[1], '.')) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid email');

        }

        if (!isset($password) || empty(str_replace(' ', '', $password)) || strlen(str_replace(' ', '', $password)) < 8) {
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
        setcookie(name:'token', value:"$jwt", path:'/', httponly:false);
        // SendEmail::sendEmail(reciever:$email, subject:'welcome to Coloco family', body:"Welcome $firstname to coloco family, we are very happy to join us, if you have anay question, do not hesitate to ask us");
        http_response_code(201);
        echo (json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));
        header('Location:/');
        exit;

    }

    //ISLOGGEDIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //ISLOGGEDIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //ISLOGGEDIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function isLoggedin()
    {
        if (!isset($_COOKIE['token']) || $_COOKIE['token'] === '') {
            ErrorHandler::run(statusCode:403, message:'Access denied, Please login to continue');
        }
        extract($_COOKIE);
        $jwt = $token;

        $decoded = GenerateJwt::verifyToken($jwt);

        if (!isset($decoded['istokenValid']) || !$decoded['istokenValid'] || !isset($decoded['userId']) || !$decoded['userId']) {
            unset($_COOKIE);
            ErrorHandler::run(statusCode:403, message:'Login session is expired, please login again to contine');
        }

        $user = UserModel::findById($decoded['userId']);

        if (!isset($user)) {
            unset($_COOKIE);
            ErrorHandler::run(statusCode:403, message:'Login session is expired, please login again to contine');
        }

        // if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {
        //     http_response_code(200);
        //     print_r(json_encode(['status' => 'success', 'data' => $user]));
        // }

        ///////////////////////////////////////

        return $user;

        ///////////////////////////////////////////////////////

    }

    //PROTECT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //PROTECT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //PROTECT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function protect(string...$roles): void
    {

        $user = self::isLoggedin();

        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'You are not logged in');
        }

        $isallowed = in_array(needle:'admin', haystack:$roles, strict:true);

        if (!$isallowed) {
            ErrorHandler::run(statusCode:403, message:'Permission denied, you are not allowed to perform the task');
        }

    }

    //LOGIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //LOGIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //LOGIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function login()
    {
        $data = json_decode(file_get_contents('php://input', true), true);

        if (!$data) {
            ErrorHandler::run(statusCode:400, message:'Please fill all the required fields');
        }

        extract($data);

        if (!isset($email) || empty(str_replace(' ', '', $email)) || !str_contains(str_replace(' ', '', $email), '@') || !str_contains(explode('@', str_replace(' ', '', $email))[1], '.')) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid email');
        }

        if (!isset($password) || empty(str_replace(' ', '', $password)) || strlen(str_replace(' ', '', $password)) < 8) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid password, password must have at least 8 chars');

        }

        $body = json_decode(json_encode($data), true);

        $user = Usermodel::findOne(['active' => 1, 'email' => $email]);
        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'User no longer exists or the credentials are incorrect');
            exit;
        }

        $isPasswordCorrect = password_verify($password, $user['password']);
        if (!$isPasswordCorrect) {
            ErrorHandler::run(statusCode:400, message:'User no longer exists or the credentials are incorrect');
            exit;
        }
        $gt = new GenerateJwt();
        $jwt = $gt->generateToken($user['id']);
        $_SESSION['token'] = $jwt;

        setcookie(name:'token', value:"$jwt", path:'/', httponly:false);

        http_response_code(200);
        echo (json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));

    }

    //GETME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //GETME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //GETME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

    //UPDATEME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //UPDATEME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //UPDATEME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function updateMe()
    {
        $user = self::isLoggedin();
        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'You are not logged in');
        }

        $body = json_decode(json_encode(json_decode(file_get_contents('php://input', true))), true);

        if (!$body) {
            ErrorHandler::run(statusCode:400, message:'No input ahs been entered');
        }
        if (array_key_exists(key:'password', array:$body)) {
            ErrorHandler::run(statusCode:403, message:'If you want to update password, please use the appropriate path');
        }
        if (array_key_exists(key:'active', array:$body)) {
            ErrorHandler::run(statusCode:403, message:'You can not reactivate your account');
        }
        if (array_key_exists(key:'role', array:$body)) {
            ErrorHandler::run(statusCode:403, message:'You can not update your role');
        }
        UserModel::findByIdAndUpdate($user['id'], $body);
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'Data has been updated successfully']));
    }

    //DELETEME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //DELETEME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //DELETEME////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function deleteMe()
    {

        $user = self::isLoggedin();

        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'You are not logged in');
        }

        UserModel::findByIdAndDelete($user['id']);
    }

    //LOGOUT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //LOGOUT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //LOGOUT////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function logout()
    {
        setcookie(name:'token', value:"", path:'/', httponly:true);
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'You are logged out successfully']));
    }
    public static function forgetpassword()
    {
        $data = json_decode(file_get_contents('php://input', true), true);

        if (!$data) {
            ErrorHandler::run(statusCode:400, message:'Please enter your registered email');
        }

        extract($data);

        if (!isset($email) || empty(str_replace(' ', '', $email)) || !str_contains(str_replace(' ', '', $email), '@') || !str_contains(explode('@', str_replace(' ', '', $email))[1], '.')) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid email');
        }

        $user = Usermodel::findOne(['active' => 1, 'email' => $email]);

        if (!isset($user)) {
            ErrorHandler::run(statusCode:404, message:'User no longer exists with the given email');
        }
        $bytes = random_bytes(20);
        $crypt = bin2hex($bytes);
        $expiresat = time() + (10 * 60);
        $link = "http://localhost:3000/api/v1/auth/resetpassword/${crypt}";
        var_dump($crypt);
        var_dump($expiresat);
        SendEmail::sendEmail(reciever:$email, subject:'RESET [LINK] valid 10 min', body:"Please use the linke to reset your password <a href=$link></a>");
        UserModel::findByIdAndUpdate($user['id'], ['crypt' => $crypt, 'expiresat' => $expiresat]);
        // http_response_code(200);
        // print_r(json_encode(['status' => 'success', 'message' => 'You are logged out successfully']));
    }

    public static function resetpassword()
    {

        $token = $_GET['token'] ?? null;
        if (!$token) {
            ErrorHandler::run(statusCode:403, message:'Link not valid');
        }
        $user = Usermodel::findOne(['active' => 1, 'crypt' => $token]);
        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'User no longer exists or the credentials are incorrect');
            exit;
        }
        extract($user);
        $now = time();
        if ($expiresat < $now) {
            UserModel::findByIdAndUpdate($user['id'], ['crypt' => 0, 'expiresat' => 0]);
            ErrorHandler::run(statusCode:400, message:'link expired, please try again');
        }

        $data = json_decode(file_get_contents('php://input', true), true);

        if (!$data) {
            ErrorHandler::run(statusCode:400, message:'Please enter your new valid password');
        }

        if (!isset($data['password']) || empty($data['password'])) {
            ErrorHandler::run(statusCode:400, message:'Please enter your new valid password');
        }
        $newPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        UserModel::findByIdAndUpdate($user['id'], ['password' => $newPassword, 'crypt' => 0, 'expiresat' => 0]);
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'Password reset successfully']));

    }

    public static function updatepassword()
    {
        $user = self::isLoggedin();
        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'You are not logged in');
        }

        $data = json_decode(file_get_contents('php://input', true), true);

        if (!$data) {
            ErrorHandler::run(statusCode:400, message:'Please fill all the required fields');
        }

        extract($data);
        if (!isset($newpassword) || empty(str_replace(' ', '', $newpassword)) || strlen(str_replace(' ', '', $newpassword)) < 8 || !isset($currentpassword) || empty(str_replace(' ', '', $currentpassword)) || strlen(str_replace(' ', '', $currentpassword)) < 8 || !isset($confirmnewpassword) || empty(str_replace(' ', '', $confirmnewpassword)) || strlen(str_replace(' ', '', $confirmnewpassword)) < 8 || $newpassword !== $confirmnewpassword) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid password and confirm it, a valid password must have at least 8 chars');
        }

        $ispasswordvalid = password_verify($currentpassword, $user['password']);
        if (!$ispasswordvalid) {
            ErrorHandler::run(statusCode:400, message:'Your current password is incorrect');
        }
        $hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        UserModel::findByIdAndUpdate($user['id'], ['password' => $hashedpassword]);
        http_response_code(200);
        echo (json_encode(['status' => 'success', 'message' => 'Password has been updated successfully']));

    }
}
