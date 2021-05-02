<?php

    namespace App\widgets;

    use App\core\base\Widget;

    class HelloWidget extends Widget {


        public $data = [];

        public function run() {

            $this->render('hello', ['data' => $this->data]);
        }


    }