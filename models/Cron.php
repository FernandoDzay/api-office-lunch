<?php

    namespace App\models;

    use App\core\Application;

    class Cron {

        private $messages;

        public function __construct() {
            $this->initializeMessages();
        }

        public function notificateBirthDay() {
            
            $current_month = (int) date('m');
            $current_day = (int) date('d');

            $query = "
                SELECT id, username FROM users
                WHERE birth_month = :current_month
                AND birth_day = :current_day
                AND status = 1
            ";

            $users = Application::$db->query($query, ['current_month' => $current_month, 'current_day' => $current_day]);

            if(empty($users)) {
                $this->messages['birthdays'] = "Nadie cumple años hoy";
                return;
            }

            $users_ids = [];
            $notifications = [];
            $this->messages['birthdays'] = [];
            foreach($users as $key => $user) {
                $users_ids[] = $user['id'];
                $notifications[] = new Notification("Cumpleaños", "Hoy es cumpleaños de " . $user['username'] . "!!");
                $this->messages['birthdays'][] = $user['username'] . ' Cumple años hoy';
            }

            foreach($notifications as $key => $notification) {
                $notification->sendAll();
            }

        }

        public function printMessages() {
            echo "<pre>";
            print_r($this->messages);
            echo "</pre>";
        }




        // -------------------------------------------- PRIVATE

        private function initializeMessages() {
            $this->messages = [
                'birthdays' => '',
            ];
        }


    }



?>