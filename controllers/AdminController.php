<?php

    namespace App\controllers;

    use App\core\base\Controller;
    use App\core\Application;
    use App\core\http\REST;
    use App\models\Food;
    use App\models\Extras;
    use App\models\Settings;


    class AdminController extends Controller {


        public function actionInsertfood() {

            $current_timestamp_ = date('Y-m-d');

            if(isset($_REQUEST['food']) && $_REQUEST['food'] != '') {
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

            if(isset($_FILES['image'])) {
                
                $mime_type = $_FILES['image']['type'];

                if( Application::$app->GlobalFunctions->isImage($mime_type) ) {

                    $image_name = $_FILES['image']['name'];
                    $folder_name = Application::$app->GlobalFunctions->generateToken();
                    $rel_dir = "food_images/" . $folder_name;

                    $result = Application::$app->GlobalFunctions->uploadImage($rel_dir, $image_name);

                    if($result) $food_image = $result;
                    else $food_image = "DEFAULT";
                }
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
            

            $food = new Food([null, $food, $short_name, $food_image, $is_temporal, $current_timestamp_, "DEFAULT", "DEFAULT"]);

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

            $current_timestamp_ = date('Y-m-d');

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
            

            $food = new Food([null, $food, $short_name, $food_image, 0, $current_timestamp_, "DEFAULT", "DEFAULT"]);

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

            $image_path_array = Application::$app->GlobalFunctions->getImagePathArray($food_id);
            
            $food = Application::$db->row("SELECT food FROM foods WHERE id=$food_id");
            $order = $food['food'];
            $date = date('Y-m-d');

            Application::$db->execute("DELETE FROM orders WHERE order_='$order' and date='$date'");

            $image_path_array = Application::$app->GlobalFunctions->getImagePathArray($food_id);

            $folder_name = $image_path_array['folder_name'];
            $image_name = $image_path_array['image_name'];

            $rel_dir = "food_images/" . $folder_name;

            if($image_name != "default_image.jpg") {
                Application::$app->GlobalFunctions->deleteImage($rel_dir, $image_name);
            }

            $food_obj = new Food();

            $food_obj->delete($food_id);

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

            $food = [
                'id' => $_REQUEST['id'],
                'short_name' => $_REQUEST['short_name'],
                'is_temporal' => $_REQUEST['is_temporal'],
                'food' => $_REQUEST['food'],
            ];

            if( isset($_FILES['image']) ) {
                
                $mime_type = $_FILES['image']['type'];

                if( Application::$app->GlobalFunctions->isImage($mime_type) ) {

                    $image_name = $_FILES['image']['name'];
                    $image_path_array = Application::$app->GlobalFunctions->getImagePathArray( $food['id'] );
                    $folder_name = $image_path_array['folder_name'];

                    if($folder_name == "food_images") {
                        $folder_name = Application::$app->GlobalFunctions->generateToken();
                    }

                    $rel_dir = "food_images/" . $folder_name;

                    $result = Application::$app->GlobalFunctions->uploadImage($rel_dir, $image_name);

                    if($result) $food['food_image'] = $result;
                }
            }


            $previous_food = Application::$db->row("SELECT * FROM foods WHERE id=:id", ['id' => $food['id']]);
            
            Application::$db->execute("UPDATE orders SET order_=:new_order WHERE order_=:previous_order AND date=:date", ['new_order' => $food['food'], 'previous_order' => $previous_food['food'], 'date' => date('Y-m-d')]);

            if( !isset($food['food_image']) ) {
                Application::$db->execute("UPDATE foods SET food=:food, short_name=:short_name, is_temporal=:is_temporal WHERE id=:id", $food);
            }
            else {
                Application::$app->GlobalFunctions->deleteImage($folder_name, $image_path_array['image_name']);
                Application::$db->execute("UPDATE foods SET food=:food, food_image=:food_image, short_name=:short_name, is_temporal=:is_temporal WHERE id=:id", $food);
            }

            die();
        }

        public function actionInsertextra() {

            $extra = new Extras([null, $_REQUEST['extra'], $_REQUEST['price']]);

            $extra->save();

            die();

        }

        public function actionDeleteextra() {

            $extra_id = $_REQUEST['id'];

            $order = Application::$db->row("SELECT extra FROM extras WHERE id=$extra_id");
            $order = $order['extra'];
            $date = date('Y-m-d');

            Application::$db->execute("DELETE FROM orders WHERE order_='$order' and date='$date'");

            $extra = new Extras();

            $extra->delete($extra_id);

        }

        public function actionEditextra() {

            $previous_extra = Application::$db->row("SELECT * FROM extras WHERE id=:id", ['id' => $_REQUEST['id']]);

            if($previous_extra['price'] ==  $_REQUEST['price']) {
                Application::$db->execute("UPDATE orders SET order_=:new_order WHERE order_=:previous_order AND date=:date", ['new_order' => $_REQUEST['extra'], 'previous_order' => $previous_extra['extra'], 'date' => date('Y-m-d')]);
            }
            else {
                Application::$db->execute("UPDATE orders SET order_=:new_order, price=(:price * quantity) WHERE order_=:previous_order AND date=:date", ['new_order' => $_REQUEST['extra'], 'price' => $_REQUEST['price'], 'previous_order' => $previous_extra['extra'], 'date' => date('Y-m-d')]);
            }

            Application::$db->execute("UPDATE extras SET extra=:extra, price=:price WHERE id=:id", ['extra' => $_REQUEST['extra'], 'price' => $_REQUEST['price'], 'id' => $_REQUEST['id']]);

        }

        public function actionSettings() {
            $settings = Settings::getSettings();
            echo json_encode($settings);
        }

        public function actionUpdatesettings() {
            if( isset($_REQUEST['save']) ) {
                if( Settings::isGroupsRotate() != $_REQUEST['groups_rotate'] ) {
                    Settings::updateGroupsRotate($_REQUEST['groups_rotate']);
                }

                if( Settings::isMenuActivated() != $_REQUEST['menu_activated'] ) {
                    Settings::updateMenuActivated($_REQUEST['menu_activated']);
                }
            }
        }

    }


?>