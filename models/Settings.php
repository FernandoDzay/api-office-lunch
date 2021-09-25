<?php

    namespace App\models;

    use App\core\Application;

    class Settings {



        public static function getSetting($setting_name) {
            $setting = Application::$db->row("SELECT * FROM settings WHERE setting = :setting_name", ['setting_name' => $setting_name]);
            return $setting;
        }

        public static function getSettings() {
            $disordered_settings = Application::$db->query("SELECT * FROM settings");
            $settings = [];

            foreach($disordered_settings as $i => $value) {
                $settings[ $value['setting'] ] = [
                    'id' => $value['id'],
                    'int_value' => $value['int_value'],
                    'string_value' => $value['string_value'],
                ];
            }
            return $settings;
        }

        public static function isGroupsRotate() {
            $setting = self::getSetting('groups_rotate');
            $is_groups_rotate = (int)$setting['int_value'];

            if($is_groups_rotate) return true;
            else return false;
        }

        public static function isMenuActivated() {
            $setting = self::getSetting('menu_activated');
            $is_menu_activated = (int)$setting['int_value'];

            if($is_menu_activated) return true;
            else return false;
        }

        public static function updateGroupsRotate($int_value) {
            if(!isset($int_value)) return;
            if($int_value != 0 && $int_value != 1) return;

            $sql = "UPDATE settings SET int_value = :int_value WHERE setting = 'groups_rotate'";
            Application::$db->execute($sql, ['int_value' => $int_value]);
        }

        public static function updateMenuActivated($int_value) {
            if(!isset($int_value)) return;
            if($int_value != 0 && $int_value != 1) return;

            $sql = "UPDATE settings SET int_value = :int_value WHERE setting = 'menu_activated'";
            Application::$db->execute($sql, ['int_value' => $int_value]);
        }



    }



?>