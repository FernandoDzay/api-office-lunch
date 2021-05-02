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

    }





?>