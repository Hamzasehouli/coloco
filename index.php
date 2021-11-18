<?php
if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {
    header('content-type:application/json');
}

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use coloco\config\Database;
use coloco\controllers\UserControllers;
use coloco\controllers\AuthControllers;
use coloco\Router;

$db = new Database();
$con = $db->connect();
$router = new Router();
// echo '<pre>';
// var_dump($_SERVER);
// echo '</pre>';

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/users')) {
   
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
    $router->post('/api/v1/auth/getme', [AuthControllers::class, 'getMe']);
    $router->post('/api/v1/auth/updateme', [AuthControllers::class, 'updateMe']);
    $router->post('/api/v1/auth/deleteme', [AuthControllers::class, 'deleteMe']);
    $router->call();
    return;
}
if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/ads')) {
    $router->get('/api/v1/ads', [UserControllers::class, 'getAds']);
    $router->post('/api/v1/ads', [UserControllers::class, 'createAd']);
    $router->get('/api/v1/ads/getad', [AdControllers::class, 'getAd']);
    $router->post('/api/v1/ads/updatead', [AdControllers::class, 'updateAd']);
    $router->post('/api/v1/ads/deletead', [AdControllers::class, 'deleteAd']);
    $router->call();
    return;
}

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {
    print_r(json_encode('This route: (' . $_SERVER['REQUEST_URI'] . ') not found in the API'));
}

?>

<!DOCTYPE html>
<html>

<body>

    <p>index</p>
</body>

</html>