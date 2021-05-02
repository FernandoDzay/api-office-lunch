<?php

    namespace App\models;

    use App\core\base\Model;

    class Login extends Model {







        
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