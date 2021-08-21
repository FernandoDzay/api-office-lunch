<?php

    namespace App\models;

    use App\core\Application;

    class Notification {

        private $title;
        private $description;
        private $created_by;
        private $type;

        public function __construct($title, $description) {
            $this->title = $title;
            $this->description = $description;
        }



        public function send($users) {

            if( isset($this->created_by) && isset($this->type) ) {

                $notification_insertion = "INSERT INTO notifications VALUES (DEFAULT, :title, :description, :created_by, :type, DEFAULT) ";
                Application::$db->execute($notification_insertion, [
                    ':title' => $this->title,
                    ':description' => $this->description,
                    ':created_by' => $this->created_by,
                    ':type' => $this->type,
                ]);

            }
            else if( isset($this->created_by) ) {

                $notification_insertion = "INSERT INTO notifications VALUES (DEFAULT, :title, :description, :created_by, DEFAULT, DEFAULT) ";
                Application::$db->execute($notification_insertion, [
                    ':title' => $this->title,
                    ':description' => $this->description,
                    ':created_by' => $this->created_by
                ]);

            }
            else if( isset($this->type) ) {

                $notification_insertion = "INSERT INTO notifications VALUES (DEFAULT, :title, :description, DEFAULT, :type, DEFAULT) ";
                Application::$db->execute($notification_insertion, [
                    ':title' => $this->title,
                    ':description' => $this->description,
                    ':type' => $this->type
                ]);

            }
            else {

                $notification_insertion = "INSERT INTO notifications VALUES (DEFAULT, :title, :description, DEFAULT, DEFAULT, DEFAULT) ";
                Application::$db->execute($notification_insertion, [
                    ':title' => $this->title,
                    ':description' => $this->description
                ]);

            }

            $notification_id = Application::$db->lastInsertId();

            $user_insertions = "";
            foreach($users as $key => $user_id) {
                $user_insertions .= "INSERT INTO assigned_notifications VALUES (DEFAULT, $notification_id, ?, DEFAULT, DEFAULT); ";
            }

            Application::$db->execute($user_insertions, $users);
        }

        public function sendAll(){
            $users = Application::$db->query("SELECT id FROM users WHERE status=1");
            foreach($users as $key => $user_data) {
                $users_array[] = $user_data['id'];
            }
            $this->send($users_array);
        }

        public static function markAsRead($ids) {

            $last_modified = date("Y-m-d h:i:s");

            $query = "";
            foreach($ids as $key => $id) {
                $query .= "UPDATE assigned_notifications SET has_been_read=1, last_modified='$last_modified' WHERE id=?; ";
            }
            Application::$db->execute($query, $ids);
        }

        public function created_by($created_by) {
            $this->created_by = $created_by;
        }

        public function type($type) {
            $this->type = $type;
        }

        public static function getNotifications($user_id) {

            $today_start = date("Y-m-d") . " 00:00:00";
            $today_end = date("Y-m-d") . " 23:59:59";

            $query = "
                SELECT a.id, title, description, type, created_by, has_been_read, created_at
                FROM notifications n
                INNER JOIN assigned_notifications a ON n.id = a.notification_id
                WHERE
                user_id = :user_id
                AND 
                (
                    has_been_read = 0
                    OR (
                            created_at >= :today_start
                            AND created_at <= :today_end
                        )
                    OR (
                            last_modified >= :today_start
                            AND last_modified <= :today_end
                        )
                )
                ORDER BY created_at
            ";

            $notifications = Application::$db->query($query, ['user_id' => $user_id, 'today_start' => $today_start, 'today_end' => $today_end]);
            return $notifications;
        }


    }



?>