<?php

    namespace App\core\base;

    class Widget {

        private static $params;
        private static Widget $widget;
        private static $widgetClass;


        public function __construct() {
            
        }

        public function render($widgetView, array $params = []) {

            if(!empty(self::$params[key($params)])) {
                $key_name = key(self::$params);
                $$key_name = self::$params[$key_name];
            }
            else {
                $key_name = key($params);
                $$key_name = $params[$key_name];
            }
            

            require $this->getWidgetPath().$widgetView.".php";
        }


        public static function begin(array $params = []) {
            self::$widget = new Widget();
            self::$widgetClass = get_called_class();
            self::$params = $params;

            self::$widget->callRun();
            
        }


        public function callRun() {
            call_user_func([new self::$widgetClass, "run"]);
        }

        public function getWidgetPath() {
            self::$widgetClass;
            $widgetPath = __DIR__."/../../widgets";

            $subDirectories = explode("\\", self::$widgetClass);

            if( count($subDirectories) > 3 ) {
                for( $i = 2; $i < (count($subDirectories) - 1); $i++ ) {
                    $widgetPath .= "/".$subDirectories[$i];
                }
            }

            $widgetPath .= "/views/";

            return $widgetPath;
        }


    }