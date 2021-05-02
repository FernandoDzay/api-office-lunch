<?php

    namespace App\core\base;

    use App\core\Config;


    class Database {

        private $dsn;
        private $user;
        private $password;
        private $db;

        public function __construct() {
            if($this->isBackendApi()) {
                $this->setParameters();
                $this->setConnexion();
            }
        }



        public function query($query, $parameters = []) {
            $stmt = $this->db->prepare($query);
            $stmt->execute($parameters);
            
            return $stmt->fetchAll();
        }

        public function execute($sql, $parameters = []) {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($parameters);
        }

        public function row($query, $parameters = []) {
            $stmt = $this->db->prepare($query);
            $stmt->execute($parameters);
            
            return $stmt->fetch();
        }





        //--------------------
        private function setParameters() {
            $this->dsn = $this->get_DSN_string();
            $this->user = Config::getDbParameters()['user'];
            $this->password = Config::getDbParameters()['password'];
        }
        private function get_DSN_string() {
            $dbname = Config::getDbParameters()['dbname'];
            $host = Config::getDbParameters()['host'];
            return "mysql:dbname={$dbname};host={$host}";
        }
        private function setConnexion() {
            try {
                $this->db = new \PDO($this->dsn, $this->user, $this->password);
                $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Falló la conexión: ' . $e->getMessage();
                die();
            }
        }
        private function isBackendApi() {
            return Config::getBackendApi();
        }







    }


?>