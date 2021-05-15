<?php

    namespace App\Controllers;

    use App\core\base\Controller;
    use App\core\Application;
    use App\core\http\Response;
    use App\models\Login;

    class SiteController extends Controller {


        public function actionIndex() {

            $user = "";
            if(isset($_REQUEST['username'])) {
                $user = $_REQUEST['username'];
            }

            
            $users = Application::$db->query("SELECT * FROM users WHERE username='$user'");
            
            
            echo json_encode($users);
        }

        public function actionGetfoods() {

            $foods = Application::$db->query("SELECT * FROM foods");

            echo json_encode($foods);
        }

        public function actionGetmenu() {
            $menu = Application::$db->query("SELECT * FROM foods f INNER JOIN menu m WHERE m.food_id = f.id");

            echo json_encode($menu);
        }

    }





?>