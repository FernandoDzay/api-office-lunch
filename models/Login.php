<?php

    namespace App\models;

    use App\core\base\Model;
    use App\core\Application;

    class Login extends Model {


        private $response_ok;
        private $response_not_ok;



        public function my_construct() {
            $this->response_ok = json_encode(['response' => true]);
            $this->response_not_ok = json_encode(['response' => false]);

            $this->tableColumns['password'] = "'".password_hash($this->password, PASSWORD_DEFAULT)."'";
        }

        public function response_ok() {
            echo $this->response_ok;
            die();
        }

        public function response_not_ok() {
            echo $this->response_not_ok;
            die();
        }
        


        public function userExist() {
            $response = Application::$db->row("SELECT * from users WHERE username=:username", ['username' => $this->username]);
            if(!empty($response)) {
                return true;
            }
            else {
                return false;
            }
        }

        public function verify() {

            $user = Application::$db->row("SELECT * from users WHERE username=:username", ['username' => $this->username]);

            if( !empty($user) ) {
                $db_password = $user['password'];

                if( password_verify($this->password, $db_password) ) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }


        




        //-------------------------------------------------
        public function setBaseColumn() {
            return 'username';
        }

        public function setTableName() {
            return 'users';
        }

        public function setTableColumns() {
            return [
                'id',
                'username',
                'password'
            ];
        }
    }



?>