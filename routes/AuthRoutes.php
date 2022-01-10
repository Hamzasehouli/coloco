<?php

declare (strict_types = 1);

namespace coloco\routes;

use coloco\controllers\AuthControllers;

class AuthRoutes
{
    public static function run($router)
    {

        $router->post('/api/v1/auth/signup', [AuthControllers::class, 'signup']);
        $router->post('/api/v1/auth/login', [AuthControllers::class, 'login']);
        $router->post('/api/v1/auth/isloggedin', [AuthControllers::class, 'isLoggedin']);
        $router->post('/api/v1/auth/protect', [AuthControllers::class, 'protect']);
        $router->post('/api/v1/auth/logout', [AuthControllers::class, 'logout']);
        $router->get('/api/v1/auth/getme', [AuthControllers::class, 'getMe']);
        $router->post('/api/v1/auth/updateme', [AuthControllers::class, 'updateMe']);
        $router->post('/api/v1/auth/forgetpassword', [AuthControllers::class, 'forgetpassword']);
        $router->post('/api/v1/auth/resetpassword', [AuthControllers::class, 'resetpassword']);
        $router->post('/api/v1/auth/updatepassword', [AuthControllers::class, 'updatepassword']);
        $router->post('/api/v1/auth/deleteme', [AuthControllers::class, 'deleteMe']);
        $router->call();

    }
}