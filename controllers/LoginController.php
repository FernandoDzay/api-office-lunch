<?php

namespace App\controllers;

use App\core\base\Controller;
use App\core\Application;
use App\models\Login;

class LoginController extends Controller {


    public function actionLogin() {

        
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        $login = new Login([null, $username, $password]);

        if( $login->verify() ) {
            $login->loginSuccess();
        }
        else {
            $login->response_not_ok();
        }

        
        
    }

    public function actionRegister() {

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        

        $register = new Login([null, $username, $password]);

        if( $register->userExist() === false ) {
            $register->save();
            $register->response_ok();
        }
        else {
            $register->response_not_ok();
        }
        
    }


}



?>