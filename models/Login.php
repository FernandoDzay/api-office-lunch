<?php

    namespace App\models;

    use App\core\base\Model;
    use App\core\Application;

    class Login extends Model {


        private $response_ok;
        private $response_not_ok;
        private $loginSuccess;



        public function my_construct() {
            $this->response_ok = json_encode(['response' => "true"]);
            $this->response_not_ok = json_encode(['response' => "false"]);

            if(isset($this->password) && isset($this->token)) {
                $this->tableColumns['password'] = "'".password_hash($this->password, PASSWORD_DEFAULT)."'";
                $this->tableColumns['token'] = "'".password_hash($this->token, PASSWORD_DEFAULT)."'";
            }
        }

        public function response_ok() {
            echo $this->response_ok;
            die();
        }

        public function response_not_ok() {
            echo $this->response_not_ok;
            die();
        }

        public function loginSuccess() {
            echo $this->loginSuccess;
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

        public function verify($username, $password) {

            $user = Application::$db->row("SELECT * from users WHERE username=:username", ['username' => $username]);

            if( !empty($user) ) {
                $db_password = $user['password'];

                if( password_verify($password, $db_password) ) {
                    $this->loginSuccess = json_encode([
                        'response' => "true",
                        'user_id' => $user['id'],
                    ]);
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

        public function verifyToken($id, $token) {

            $user = Application::$db->row("SELECT * from users WHERE id=:id", ['id' => $id]);

            if( !empty($user) ) {

                $db_token = $user['token'];

                if( password_verify($token, $db_token) ) {
                    $this->loginSuccess = json_encode([
                        'response' => "true",
                        'user_id' => $user['id'],
                    ]);
                    return true;
                }

            }
            else {
                return false;
            }

        }

        public function updateUserToken($username, $token) {
            $new_token = password_hash($token, PASSWORD_DEFAULT);

            Application::$db->execute("UPDATE users SET token=:new_token WHERE username=:username", ['username' => $username, 'new_token' => $new_token]);
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
                'password',
                'token',
                'image',
                'birth_month',
                'birth_day',
                'is_guest',
                'is_admin',
                'status'
            ];
        }
    }



?>