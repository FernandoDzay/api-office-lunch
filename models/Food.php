<?php

    namespace App\models;

    use App\core\base\Model;
    use App\core\Application;

    class Food extends Model {


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


        public function getFoodByName($name) {
            $food = Application::$db->row("SELECT * FROM foods WHERE food=:food", ['food' => $name]);
            return $food;
        }

        public function getDiscountPriceByName($name) {
            $food = Application::$db->row("SELECT discount_price FROM foods WHERE food=:food", ['food' => $name]);
            return $food['discount_price'];
        }

        public function getActualPriceByName($name) {
            $food = Application::$db->row("SELECT actual_price FROM foods WHERE food=:food", ['food' => $name]);
            return $food['actual_price'];
        }

        public function deleteNoSavedFoods() {
            $query = 
            "
                DELETE FROM foods WHERE is_temporal = 1;
            ";

            $result = Application::$db->execute($query);
            return $result;
        }

    


        //-------------------------------------------------
        public function setBaseColumn() {
            return 'id';
        }

        public function setTableName() {
            return 'foods';
        }

        public function setTableColumns() {
            return [
                'id',
                'food',
                'short_name',
                'food_image',
                'is_temporal',
                'last_update',
                'discount_price',
                'actual_price'
            ];
        }
    }



?>