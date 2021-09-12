<?php

namespace App\controllers;

use App\core\base\Controller;
use App\core\Application;
use App\models\Login;

class LoginController extends Controller {


    public function actionLogin() {

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $token = $_REQUEST['token'];

        $login = new Login();

        if( $login->verify($username, $password) ) {
            $login->updateUserToken($username, $token);
            $login->loginSuccess();
        }
        else {
            $login->response_not_ok();
        }
        
    }

    public function actionRegister() {

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $birth_month = $_REQUEST['birth_month'];
        $birth_day = $_REQUEST['birth_day'];

    
        $register = new Login([null, $username, $password, $password, "DEFAULT", $birth_month, $birth_day, "DEFAULT", "DEFAULT", "DEFAULT"]);

        if( $register->userExist() === false ) {
            $register->save();
            $register->response_ok();
        }
        else {
            $register->response_not_ok();
        }
        
    }

    public function actionTokenlogin() {

        if(!isset($_REQUEST['id']) && !isset($_REQUEST['token'])) die();

        $id = $_REQUEST['id'];
        $token = $_REQUEST['token'];

        $login = new Login();

        if($login->verifyToken($id, $token)) {
            $login->loginSuccess();
        }
        else {
            $login->response_not_ok();
        }
    }


}



?>