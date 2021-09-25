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

        public function groupsClockWise() {
            $usersGroup = new UsersGroup();
            $usersGroup->groupsClockWise();
            $this->messages['groupsClockWise'] = 'Grupos actualizados';
        }

        public function deleteNoSavedFoods() {
            $food = new Food();
            $food->deleteNoSavedFoods();
            $this->messages['foods'] = 'Las comidas no guardadas, han sido borradas';
        }

        public function resetMenu() {
            $sql = "DELETE FROM menu";

            Application::$db->execute($sql);
            $this->messages['menu'] = 'El menu ha sido reseteado';
        }









        public function responseMessages() {
            echo json_encode($this->messages);
        }


        // -------------------------------------------- PRIVATE

        private function initializeMessages() {
            $this->messages = [
                'birthdays' => '',
                'groupsClockWise' => '',
                'foods' => '',
                'menu' => '',
            ];
        }


    }



?>