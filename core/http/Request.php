<?php

namespace App\core\http;

use App\core\Config;

class Request {

    protected Response $response;
    protected Router $router;
    protected $config;
    protected $controller;
    protected $method;


    public function __construct() {
        $this->router = new Router();
        $this->setController();
        $this->setMethod();
        $this->response = new Response($this->controller, $this->method);
    }


    public function setController() {
        $route = $this->router->getRoute( $this->getUrl() );
        if( is_string($route) ) {
            $this->controller = explode("/", $route)[0];
        }
        else {
            Response::notFound();
            //echo "<h1>Not found</h1>";
            die();
        }
    }
    
    public function setMethod() {
        $route = $this->router->getRoute( $this->getUrl() );
        if( is_string($route) ) {
            $this->method = explode("/", $route)[1];
        }
        else {
            Response::notFound();
            //echo "<h1>Not found</h1>";
            die();
        }
    }

    public function getUrl() {
        $strpos = strpos($_SERVER["REQUEST_URI"], "?");

        if( $strpos != false ) {
            $url = substr($_SERVER["REQUEST_URI"], 0, $strpos);
            return $url;
        }
        else {
            $url = $_SERVER["REQUEST_URI"];
            return $url;
        }
    }



    public function sendResponse() {
        $this->response->send();
    }

}
