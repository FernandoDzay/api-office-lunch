<?php

    namespace App\widgets;

    use App\core\base\Widget;

    class LoginHeaderWidget extends Widget {


        public $data = [];

        public function run() {

            $this->render('login-header', ['data' => $this->data]);
        }


    }
?>