<?php

declare(strict_types=1);

namespace coloco\controllers;

use coloco\helpers\GenerateJwt;
use coloco\helpers\ErrorHandler;
use coloco\models\Usermodel;
use coloco\helpers\SendEmail;
class AuthControllers
{
    //SIGNUP////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //SIGNUP////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //SIGNUP////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        setcookie(name:'token', value:"$jwt", path:'/', httponly:true);
        SendEmail::sendEmail(reciever: $email, subject: 'welcome to Coloco family', body: "Welcome $firstname to coloco family, we are very happy to join us, if you have anay question, do not hesitate to ask us");
        http_response_code(201);
        echo(json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));

    }

     //ISLOGGEDIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //ISLOGGEDIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //ISLOGGEDIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function isLoggedin()
    {
        if (!isset($_COOKIE['token'])|| $_COOKIE['token'] ==='') {
            ErrorHandler::run(statusCode:403, message:'Access denied, Please login to continue');
        }
        extract($_COOKIE);
        $jwt = $token;
        
        $decoded = GenerateJwt::verifyToken($jwt);

        if (!isset($decoded['istokenValid'])||!$decoded['istokenValid']||!isset($decoded['userId'])||!$decoded['userId']) {
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

    public static function protect(string ...$roles):void
    {
        
        $user = self::isLoggedin();
       
        if (!isset($user)) {
            ErrorHandler::run(statusCode:400, message:'You are not logged in');
        }
        
        $isallowed = in_array(needle :'admin', haystack: $roles, strict: true);

        if (!$isallowed) {
            ErrorHandler::run(statusCode:403, message:'Permission denied, you are not allowed to perform the task');
        }
        
    }

     //LOGIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //LOGIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //LOGIN////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function login()
    {
        $data = json_decode(file_get_contents('php://input', true),true);

        if(!$data){
            ErrorHandler::run(statusCode:400, message:'Please fill all the required fields');
        }

        extract($data);

        if (!isset($email)||empty(str_replace(' ', '', $email)) || !str_contains(str_replace(' ', '', $email), '@') || !str_contains(explode('@', str_replace(' ', '', $email))[1], '.')) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid email');
        }

        if (!isset($password)||empty(str_replace(' ', '', $password)) || strlen(str_replace(' ', '', $password)) < 8) {
            ErrorHandler::run(statusCode:400, message:'Please enter a valid password, password must have at least 8 chars');
            
        }

        $body = json_decode(json_encode($data), true);

        $user = Usermodel::findOne(['active'=>1, 'email'=>$email]);
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

        setcookie(name:'token', value:"$jwt", path:'/', httponly:true);
       
        http_response_code(200);
        echo(json_encode(['status' => 'success', 'data' => ['user' => $user, 'token' => $jwt]]));

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
        if(array_key_exists(key:'password', array:$body)){
            ErrorHandler::run(statusCode:403, message:'If you want to update password, please use the appropriate path');
        }
        if(array_key_exists(key:'active', array:$body)){
            ErrorHandler::run(statusCode:403, message:'You can not reactivate your account');
        }
        if(array_key_exists(key:'role', array:$body)){
            ErrorHandler::run(statusCode:403, message:'You can not update your role');
        }
        UserModel::findByIdAndUpdate($user['id'], $body);
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
}