<?php

    namespace App\HandleRequest;

    use App\core\http\Response;

    class HandleRequest {

        protected Response $response;
        protected $controller;
        protected $method;

        public function __construct() {
            $this->response = new Response();
            $this->controller = "App\Controllers\SiteController";
            $this->method = "actionLogin";
        }



        public function run() {

            //$this->response->executeController($this->controller, $this->method);
            return true;
        }



    }



?>