<?php


    namespace App\GlobalFunctions;


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

    }

