<?php

declare (strict_types = 1);

session_start();

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/')) {
    header('content-type:application/json');
}
;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use coloco\config\Database;
use coloco\Router;
use coloco\routes\AdRoutes;
use coloco\routes\AuthRoutes;
use coloco\routes\UserRoutes;
use coloco\routes\ViewRoutes;

Database::connect();
$router = new Router();

ViewRoutes::run($router);

if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/users')) {
    UserRoutes::run($router);
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
