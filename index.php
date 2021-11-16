<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use coloco\config\Database;
use coloco\Router;

$db = new Database();
$con = $db->connect();
$router = new Router();
echo '<pre>';
var_dump($_SERVER);
echo '</pre>';

if(str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/users')){
$router->get('/api/v1/users', [UserControllers::class, 'getUsers']);
$router->post('/api/v1/users', [UserControllers::class, 'createUser']);
$router->get('/api/v1/users/getuser', [UserControllers::class, 'getUser']);
$router->post('/api/v1/users/updateuser', [UserControllers::class, 'updateUser']);
$router->post('/api/v1/users/deleteuser', [UserControllers::class, 'deleteUser']);
$router->call();
}

echo 'No route found';

