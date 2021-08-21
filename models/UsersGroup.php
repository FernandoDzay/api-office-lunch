<?php

    namespace App\models;

    use App\core\base\Model;
    use App\core\Application;

    class UsersGroup extends Model {


        private $response_ok;
        private $response_not_ok;
        private $loginSuccess;



        public function my_construct() {
            $this->response_ok = json_encode(['response' => "true"]);
            $this->response_not_ok = json_encode(['response' => "false"]);
        }
        public function response_ok() {
            echo $this->response_ok;
            die();
        }
        public function response_not_ok() {
            http_response_code ( 404 );
            echo $this->response_not_ok;
            die();
        }



        public function updateUserGroup($user_id, $group_id) {
            Application::$db->execute("UPDATE users_group SET group_id=$group_id WHERE user_id=$user_id");
        }

        public function activateUserStatus($user_id) {
            Application::$db->execute("UPDATE users_group SET status=1 WHERE user_id=$user_id");
        }

        public function desActivateUserStatus($user_id) {
            Application::$db->execute("UPDATE users_group SET status=0 WHERE user_id=$user_id");
        }

        public function removeUserGroup($user_id) {
            Application::$db->execute("DELETE FROM users_group WHERE user_id=$user_id");
        }


    


        //-------------------------------------------------
        public function setBaseColumn() {
            return 'user_id';
        }

        public function setTableName() {
            return 'users_group';
        }

        public function setTableColumns() {
            return [
                'user_id',
                'group_id',
                'temporal_group_id',
                'status'
            ];
        }
    }



?>