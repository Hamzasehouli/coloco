<?php
declare(strict_types=1);
    namespace coloco\routes;
    use coloco\controllers\ViewControllers;
    use coloco\Router;

  

    class ViewRoutes{ 
        public static function run($router) :void{
            $router->get('/', [ViewControllers::class, 'overview']);
            $router->get('/signup', [ViewControllers::class, 'signup']);
            $router->get('/login', [ViewControllers::class, 'login']);
            $router->get('/ads', [ViewControllers::class, 'ads']);
            $router->get('/ad', [ViewControllers::class, 'ad']);
            $router->get('/profile', [ViewControllers::class, 'profile']);
            $router->get('/error', [ViewControllers::class, 'renderError']);
            $router->call();
        }
    }
   





