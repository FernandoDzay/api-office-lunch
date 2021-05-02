<?php

namespace App\core\http;

use App\core\Config;

class Router {

    public function getRoute($url) {
        $rules = Config::getRules();
        if($this->isBackendApi()) {
            return $this->getRequestRuleByMethod($rules, $url);
        }
        else {
            return $this->getRequestRule($rules, $url);
        }
    }



    public function getRequestRule($rules, $url) {
        foreach($rules as $i => $rule) {
            if($rule['pattern'] == $url) {
                return $rule['route'];
            }
        }
        return false;
    }

    public function getRequestRuleByMethod($rules, $url) {
        foreach($rules as $i => $rule) {
            if( !isset($rule['method']) ) die("You most define all methods");

            if($rule['pattern'] == $url && $rule['method'] == $_SERVER['REQUEST_METHOD']) {
                return $rule['route'];
            }
        }
        return false;
    }

    public function isBackendApi() {
        return Config::getBackendApi();
    }

}


