<?php

namespace App\core\base;

use App\core\Config;
use App\core\Application;

class Controller {

    protected $config;
    protected $layout;

    public function __construct() {
        
    }

    


    public function render($view, array $params = []) {

        $content = $this->getViewFile($view, $params);

        return $this->printLayout($content);
    }




    public function setLayout($layout) {
        $this->layout = $layout;
    }
    
    private function getViewFile($view, $params) {
        if( !empty($params) ) {
            foreach($params as $i => $param) {
                $$i = $param;
            }
        }

        ob_start();
        if( $this->aPathIsSet($view) ) {
            require __DIR__."/../../views".$view.".php";
        }
        else {
            require __DIR__."/../../views/".$this->getFolderName()."/$view.php";
        }
        return ob_get_clean();
    }

    private function printLayout($content) {
        ob_start();

        if( isset($this->layout) ) {
            require __DIR__."/../../views/layouts/$this->layout.php";
        }
        else {
            require __DIR__."/../../views/layouts/".Config::getLayout().".php";
        }

        return ob_get_contents();
    }

    private function getFolderName() {
        $folderName = get_class($this);

        $folderName = explode("\\", $folderName);

        $folderName = $folderName[count($folderName) - 1];

        $folderName = substr($folderName, 0, -10);

        $folderName = strtolower($folderName);

        return $folderName;
    }

    private function aPathIsSet($view) {
        return !(strpos($view, "/") === false);
    }
    
}



?>