<?php

    namespace App\core;

    use App\core\http\Request;
    use App\core\http\Response;
    use App\core\base\Database;

    class Application {

        public static Helpers $app;
        public static Database $db;

        public function __construct() {
            new Config();
            self::$app = new Helpers();
            self::$db = new Database();
        }

        

        public static function run() {
            $request = new Request();
            $request->sendResponse();
        }

    }


?>