<?php
if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {
    header('content-type:application/json');
}

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once './env.php';

use coloco\config\Database;
use coloco\controllers\AdControllers;
use coloco\controllers\AuthControllers;
use coloco\controllers\UserControllers;
use coloco\controllers\ViewControllers;
use coloco\Router;

$db = new Database();
$con = $db->connect();
$router = new Router();
// echo '<pre>';
// var_dump($_SERVER);
// echo '</pre>';

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/users')) {
    AuthControllers::protect();
    // $param = explode('=', explode('&', $_SERVER['QUERY_STRING'])[0])[1];
    $router->get('/api/v1/users', [UserControllers::class, 'getUsers']);
    $router->post('/api/v1/users', [UserControllers::class, 'createUser']);
    $router->get("/api/v1/users/getuser", [UserControllers::class, 'getUser']);
    $router->post('/api/v1/users/updateuser', [UserControllers::class, 'updateUser']);
    $router->post('/api/v1/users/deleteuser', [UserControllers::class, 'deleteUser']);
    $router->call();
    return;
}
if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/auth')) {

    $router->post('/api/v1/auth/signup', [AuthControllers::class, 'signup']);
    $router->post('/api/v1/auth/login', [AuthControllers::class, 'login']);
    $router->post('/api/v1/auth/isloggedin', [AuthControllers::class, 'isLoggedin']);
    $router->post('/api/v1/auth/protect', [AuthControllers::class, 'protect']);
    $router->post('/api/v1/auth/logout', [AuthControllers::class, 'logout']);
    $router->get('/api/v1/auth/getme', [AuthControllers::class, 'getMe']);
    $router->post('/api/v1/auth/updateme', [AuthControllers::class, 'updateMe']);
    $router->post('/api/v1/auth/deleteme', [AuthControllers::class, 'deleteMe']);
    $router->call();
    return;
}
if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/ads')) {
    $router->get('/api/v1/ads', [AdControllers::class, 'getAds']);
    $router->get('/api/v1/ads/getad', [AdControllers::class, 'getAd']);
    $router->post('/api/v1/ads', [AdControllers::class, 'createAd']);
    $router->post('/api/v1/ads/updatead', [AdControllers::class, 'updateAd']);
    $router->post('/api/v1/ads/deletead', [AdControllers::class, 'deleteAd']);
    $router->call();
    return;
}

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {
    print_r(json_encode('This route: (' . $_SERVER['REQUEST_URI'] . ') not found in the API'));
}

// include_once './views/base.php';

$router->get('/', [ViewControllers::class, 'overview']);
$router->get('/signup', [ViewControllers::class, 'signup']);
$router->get('/login', [ViewControllers::class, 'login']);
$router->get('/ads', [ViewControllers::class, 'ads']);
$router->get('/ad', [ViewControllers::class, 'ad']);
$router->get('/profile', [ViewControllers::class, 'profile']);
$router->call();
return;