<?php
declare(strict_types=1);

    namespace coloco\routes;
    use coloco\controllers\AdControllers;
    use coloco\controllers\AuthControllers;
    use coloco\Router;

    

    class AdRoutes{ 
        public static function run($router) :void{
            $router->get('/api/v1/ads', [AdControllers::class, 'getAds']);
            $router->get('/api/v1/ads/getad', [AdControllers::class, 'getAd']);
            $router->post('/api/v1/ads', [AdControllers::class, 'createAd']);
            $router->post('/api/v1/ads/updatead', [AdControllers::class, 'updateAd']);
            $router->post('/api/v1/ads/deletead', [AdControllers::class, 'deleteAd']);
            $route = $_SERVER['REQUEST_URI'];
            
            if((str_starts_with($route,'/api/v1/ads') && $_SERVER['REQUEST_METHOD'] === 'GET') || str_starts_with($route,'/api/v1/ads/getad')){
                $router->call();
                exit;   
            }else{
                AuthControllers::isLoggedIn();
                $router->call();
            }
        }
    }
   