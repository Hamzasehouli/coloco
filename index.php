<?php

declare(strict_types=1);

session_start();


if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {
    header('content-type:application/json');
};

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once './env.php';

use coloco\config\Database;
use coloco\controllers\AdControllers;
use coloco\controllers\AuthControllers;
use coloco\controllers\UserControllers;
use coloco\controllers\ViewControllers;
use coloco\routes\AuthRoutes;
use coloco\routes\UserRoutes;
use coloco\routes\AdRoutes;
use coloco\routes\ViewRoutes;
use coloco\Router;


$con = Database::connect();
$router = new Router();


if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/users')) {
    AuthRoutes::run($router);
    exit;
}

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/auth')) {
    AuthRoutes::run($router);
    exit;
}

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/ads')) {
    AdRoutes::run($router);
    exit;
}


ViewRoutes::run($router);




