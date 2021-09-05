<?php


    namespace App\GlobalFunctions;

    use App\core\Application;


    class GlobalFunctions {

        public function __construct() {
            
        }


        public function sayHello() {
            echo "saying hello from GlobalFunctions";
        }

        public function getMonday($current_date = "") {

            if($current_date != "") {
                $day_number_of_week = date('N', strtotime($current_date));
            }
            else {
                $current_date = date('Y-m-d');
                $day_number_of_week = date('N');
            }

            if($day_number_of_week > 1) {
                $substraction = $day_number_of_week - 1;
                $date = date('Y-m-d', strtotime($current_date . " - $substraction " . "days"));
            }
            else {
                $date = $current_date;
            }

            return $date;
        }

        public function transformDateToDay($date) {

            $week = [
                1 => 'lunes',
                2 => 'martes',
                3 => 'miercoles',
                4 => 'jueves',
                5 => 'viernes',
            ];

            $day_number_of_week = date("N", strtotime($date));
            
            $day = $week[$day_number_of_week];

            return $day;
        }

        public function uploadImage($rel_dir, $image_name) {

            if( empty($_FILES) ) return false;

            $dir =  __DIR__ . "/../public/img/" . $rel_dir;

            if( !is_dir($dir) ) {
                mkdir($dir);
            }

            $uploaded_file = $_FILES['image']['tmp_name'];

            $destination_name = $dir . "/" . $image_name;

            $result = move_uploaded_file($uploaded_file, $destination_name);

            if($result) {
                return "http://local.api-office-lunch/img/" . $rel_dir . "/" . $image_name;
            }
            else {
                return false;
            }
        }

        public function generateToken() {
            $random_bytes = random_bytes(16);
            $token = bin2hex($random_bytes);
            return $token;
        }

        public function isImage($mime_type) {

            $array = ['image/png', 'image/jpeg', 'image/webp'];

            if( in_array($mime_type, $array) ) return true;
            else return false;
        }

        public function getImagePathArray($id) {

            $food = Application::$db->row("SELECT * FROM foods WHERE id=:id", ['id' => $id]);
            
            $food_image = $food['food_image'];

            $array = explode("/", $food_image);

            $folder_name = $array[ sizeof($array) - 2 ];
            $image_name = $array[ sizeof($array) - 1 ];

            $image_path_array = [
                'folder_name' => $folder_name,
                'image_name' => $image_name
            ];

            return $image_path_array;
        }

        public function deleteImage($rel_dir, $image_name) {

            $dir =  __DIR__ . "/../public/img/" . $rel_dir;

            if( !is_dir($dir) ) {
                return false;
            }
            if( !file_exists($dir . "/" . $image_name) ) {
                return false;
            }

            unlink( $dir . "/" . $image_name );

            if( sizeof(scandir($dir)) < 3 ) {
                rmdir($dir);
            }

            return true;
        }

    }

