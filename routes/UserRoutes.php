<?php
declare (strict_types = 1);
namespace coloco\routes;

use coloco\controllers\AuthControllers;
use coloco\controllers\UserControllers;

class UserRoutes
{
    public static function run($router): void
    {
        AuthControllers::protect();
        $router->get('/api/v1/users', [UserControllers::class, 'getUsers']);
        $router->post('/api/v1/users', [UserControllers::class, 'createUser']);
        $router->get("/api/v1/users/getuser", [UserControllers::class, 'getUser']);
        $router->post('/api/v1/users/updateuser', [UserControllers::class, 'updateUser']);
        $router->post('/api/v1/users/deleteuser', [UserControllers::class, 'deleteUser']);
        $router->call();
    }
}