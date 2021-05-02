<?php

    namespace App\core;

    class Config {

        private static $config;

        public function __construct() {
            $this->setConfig();
        }


        public static function getRules() {
            return self::$config['components']['urlManager']['rules'];
        }

        public static function getLayout () {
            return self::$config['layout'];
        }

        public static function getFunctions() {
            return self::$config['components']['functions'];
        }

        public static function beforeRequestIsSet() {
            return (isset(self::$config['beforeRequest']) && self::$config['beforeRequest'] != '');
        }

        public static function getDbParameters() {
            if( isset(self::$config['db']) ) {
                return self::$config['db'];
            }
            else {
                return false;
            }
        }

        public static function getBackendApi() {
            return self::$config['backendApi'];
        }


        private function setConfig() {
            ob_start();
            require __DIR__."/../config/web.php";
            self::$config = $config;
            ob_clean();
        }
        



    }