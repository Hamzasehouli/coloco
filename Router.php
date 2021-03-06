<?php

declare(strict_types=1);

namespace coloco;

class Router
{
    private $getRoutes;
    private $postRoutes;

    public function get($url, $fn):void
    {
        $this->getRoutes[$url] = $fn;
    }
    public function post($url, $fn):void
    {
        $this->postRoutes[$url] = $fn;
    }

    public function call()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['PATH_INFO'] ?? '/';
        
        $fn = null;

        if ($method === 'GET') {
            if(isset($this->getRoutes[$path])){
               
                $fn = $this->getRoutes[$path];
            }
        } else {
            if(isset($this->postRoutes[$path])){
                $fn = $this->postRoutes[$path];
            }
        }
        if ($fn) {
            call_user_func($fn);
        } else {

            if (str_starts_with($_SERVER["REQUEST_URI"], '/api/v1/auth')) {
               http_response_code(404);
               echo(json_encode(['status'=>'fail', 'message'=> 'This route: ' . $_SERVER['REQUEST_URI'] . ' not found in this API']));
           }else{
            header('Location:/error');
           }
            exit;
        }
    }
}

