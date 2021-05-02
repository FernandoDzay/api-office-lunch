<?php

    namespace App\core\http;

    use App\core\Config;

    class Response {

        protected $controller;
        protected $method;

        public function __construct($controller = "", $method = "") {
            $this->controller = ucfirst($controller);
            $this->method = ucfirst($method);
        }

        

        public function send() {
            
            $controllerClass = "App\controllers\\{$this->controller}Controller";
            $controllerMethod = "action$this->method";

            if( $this->runHandleRequest() ) {
                $this->executeController($controllerClass, $controllerMethod);
            }

        }

        public static function notFound() {
            http_response_code ( 404 );
            exit;
        }


        private function runHandleRequest() {
            $handleRequestClass = "App\HandleRequest\HandleRequest";
            return call_user_func([new $handleRequestClass, "run"]);
        }

        public function executeController($controller, $method) {
            call_user_func([new $controller, $method]);
        }

    }

?>