<?php

    namespace App\controllers;

    use App\core\base\Controller;
    use App\core\Application;
    use App\core\http\REST;
    use App\models\Food;


    class AdminController extends Controller {


        public function actionInsertfood() {

            if(isset($_REQUEST['food'])) {
                $food = $_REQUEST['food'];
            }
            else {
                http_response_code ( 404 );
                die();
            }

            if(isset($_REQUEST['short_name'])) {
                $short_name = $_REQUEST['short_name'];
            }
            else {
                $short_name = null;
            }

            if(isset($_REQUEST['food_image'])) {
                $food_image = $_REQUEST['food_image'];
            }
            else {
                $food_image = "DEFAULT";
            }

            if(isset($_REQUEST['is_temporal'])) {
                $is_temporal = $_REQUEST['is_temporal'];
            }
            else {
                $is_temporal = "DEFAULT";
            }
            

            $food = new Food([null, $food, $short_name, $food_image, $is_temporal, "DEFAULT"]);

            $food->save();
            $food->response_ok();
            die();
            
        }

        public function actionInsertTodaysfood() {

            if(isset($_REQUEST['food_id'])) {
                $food_id = $_REQUEST['food_id'];
            }
            else {
                http_response_code ( 404 );
                die();
            }
            

            Application::$db->execute("INSERT INTO menu values ($food_id)");
            die();
            
        }

        public function actionSavefood() {

            if(isset($_REQUEST['food'])) {
                $food = $_REQUEST['food'];
            }
            else {
                http_response_code ( 404 );
                die();
            }

            if(isset($_REQUEST['short_name'])) {
                $short_name = $_REQUEST['short_name'];
            }
            else {
                $short_name = null;
            }

            if(isset($_REQUEST['food_image'])) {
                $food_image = $_REQUEST['food_image'];
            }
            else {
                $food_image = "DEFAULT";
            }
            

            $food = new Food([null, $food, $short_name, $food_image, 0, "DEFAULT"]);

            $food->save();
            $food->response_ok();
            die();
            
        }

        public function actionDeletefoodfrommenu() {
            if(isset($_REQUEST['delete_id'])) {
                $food_id = $_REQUEST['delete_id'];
            }
            else {
                http_response_code ( 404 );
                die();
            }
            

            Application::$db->execute("DELETE FROM menu WHERE food_id=$food_id");
            die();
        }

        public function actionDeletefood() {
            if(isset($_REQUEST['delete_food'])) {
                $food_id = $_REQUEST['delete_food'];
            }
            else {
                http_response_code ( 404 );
                die();
            }

            $food = new Food();

            $food->delete($food_id);
            Application::$db->execute("DELETE FROM menu WHERE food_id=$food_id");

            die();
        }

        public function actionMakepermanent() {
            if(isset($_REQUEST['make_permanent'])) {
                $food_id = $_REQUEST['make_permanent'];
            }
            else {
                http_response_code ( 404 );
                die();
            }

            $food = new Food();

            $food->update($food_id, ['is_temporal' => 0]);

            die();
        }

        public function actionEditfood() {
            if(!isset($_REQUEST['id'])) {
                http_response_code ( 404 );
                die();
            }

            if($food['food_image'] == "") {
                $food = [
                    'id' => $_REQUEST['id'],
                    'short_name' => $_REQUEST['short_name'],
                    'is_temporal' => $_REQUEST['is_temporal'],
                    'food' => $_REQUEST['food'],
                ];
            }
            else {
                $food = [
                    'id' => $_REQUEST['id'],
                    'food_image' => $_REQUEST['food_image'],
                    'short_name' => $_REQUEST['short_name'],
                    'is_temporal' => $_REQUEST['is_temporal'],
                    'food' => $_REQUEST['food'],
                ];
            }

            if($food['food_image'] == "") {
                Application::$db->execute("UPDATE foods SET food=:food, short_name=:short_name, is_temporal=:is_temporal WHERE id=:id", $food);
            }
            else {
                Application::$db->execute("UPDATE foods SET food=:food, food_image=:food_image, short_name=:short_name, is_temporal=:is_temporal WHERE id=:id", $food);
            }


            die();
        }


    }


?>