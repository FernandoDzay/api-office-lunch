<?php

    namespace App\models;

    use App\core\base\Model;
    use App\core\Application;

    class Extras extends Model {


        private $response_ok;
        private $response_not_ok;



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

        public function getPriceByName($name) {
            $food = Application::$db->row("SELECT price FROM extras WHERE extra=:extra", ['extra' => $name]);
            return $food['price'];
        }

        public function getExtras() {
            $extras = Application::$db->query("SELECT * FROM extras");
            return $extras;
        }
        
    


        //-------------------------------------------------
        public function setBaseColumn() {
            return 'id';
        }

        public function setTableName() {
            return 'extras';
        }

        public function setTableColumns() {
            return [
                'id',
                'extra',
                'price'
            ];
        }
    }



?>