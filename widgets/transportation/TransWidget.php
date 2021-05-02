<?php

    namespace App\widgets\transportation;

    use App\core\base\Widget;

    class TransWidget extends Widget {


        public $data = [];

        public function run() {

            $this->render('trans', ['data' => $this->data]);
        }


    }