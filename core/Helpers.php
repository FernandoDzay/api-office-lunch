<?php

    namespace App\core;

    class Helpers {

        public function __construct() {

            $this->setFunctions();

        }


        public function getInstance() {
            $classname = "http\GlobalFunctions\\".$this->classname;

            return new $classname();
        }

        private function setFunctions() {
            $functions = Config::getFunctions();
            foreach($functions as $classname => $callback) {
                $this->$classname = new $callback['class'];
            }
        }


        



    }

?>