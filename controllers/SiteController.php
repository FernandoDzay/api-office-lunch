<?php

    namespace App\Controllers;

    use App\core\base\Controller;
    use App\core\Application;
    use App\core\http\Response;
    use App\models\Login;
    use App\models\Extras;
    use App\models\Cron;
    use App\models\Notification;

    class SiteController extends Controller {


        public function actionIndex() {

            echo "Welcome to Office Lunch Api";

            $notification = new Notification("prueba", "esta es una prueba");

            $notification->sendAll();

            /* $user = "";
            if(isset($_REQUEST['username'])) {
                $user = $_REQUEST['username'];
            }

            
            $users = Application::$db->query("SELECT * FROM users WHERE username='$user'");
            
            
            echo json_encode($users); */
        }

        public function actionGetfoods() {

            $foods = Application::$db->query("SELECT * FROM foods");

            echo json_encode($foods);
        }

        public function actionGetmenu() {
            $menu = Application::$db->query("SELECT * FROM foods f INNER JOIN menu m WHERE m.food_id = f.id");

            echo json_encode($menu);
        }

        public function actionGetextras() {
            $extras = new Extras();

            $extras = $extras->getExtras();

            echo json_encode($extras);

        }

        public function actionGetusername() {

            $user_id = $_REQUEST['user_id'];

            $user = Application::$db->row("SELECT username FROM users WHERE id=:id", ['id' => $user_id]);

            echo json_encode($user['username']);
        }

        public function actionGetusers() {
            $users = Application::$db->query("SELECT id, username FROM users ORDER BY username");
            echo json_encode($users);
        }





        public function actionCron() {
            header('Content-Type: text/html');

            $cron = new Cron();

            $cron->notificateBirthDay();


            $cron->printMessages();

        }

        public function actionUploadfoodimage() {

            if( !isset($_FILES['image']) ) return;
            $image_name = $_FILES['image']['name'];
            $folder_name = Application::$app->GlobalFunctions->generateToken();
            $rel_dir = "food_images/" . $folder_name;


            $result = Application::$app->GlobalFunctions->uploadImage($rel_dir, $image_name);

            if($result) {
                echo $result;
            }
            else {
                echo "no subido";
            }

        }

    }





?>