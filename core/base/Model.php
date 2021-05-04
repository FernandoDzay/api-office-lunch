<?php

    namespace App\core\base;

    use App\core\Application;

    class Model {

        public array $tableColumns;
        private $tableName;
        private $baseColumn;

        
        public function __construct($params = []) {

            if(method_exists($this, "setTableName")) {
                $this->tableName = $this->setTableName();
            }
            if(method_exists($this, "setBaseColumn")) {
                $this->baseColumn = $this->setBaseColumn();
            }
            if(!empty($params)) {
                if(method_exists($this, "setTableColumns")) {
                    $this->setProperties($params);
                }
            }
            if(method_exists($this, "my_construct")) {
                $this->my_construct();
            }
 
        }


        private function setProperties($params = []) {
            $this->tableColumns = [];

            $i = 0;
            foreach($this->setTableColumns() as $property_key) {
                $this->$property_key = $params[$i];
                $this->tableColumns[$property_key] = $params[$i];
                $i++;
            }

            
            $this->tableColumns = $this->transformParams($this->tableColumns);
        }

        private function getTableColumns() {
            return $this->tableColumns;
        }

        public function transformParams($params) {
            $transformedParams = [];

            foreach($params as $key => $param) {
                if(is_string($param)) {
                    $transformedParams[$key] = "'".$param."'";
                }
                elseif($param === null) {
                    $transformedParams[$key] = "null";
                }
                else {
                    $transformedParams[$key] = $param;
                }
            }

            return $transformedParams;
        }

        public function transformParam($param) {

            if(is_string($param)) {
                $transformedParam = "'".$param."'";
            }
            elseif($param === null) {
                $transformedParam = "null";
            }
            else {
                $transformedParam = $param;
            }

            return $transformedParam;
        }

        public function getTableName() {
            return $this->tableName;
        }   

        

        public function save() {

            $values = implode(', ', array_values($this->tableColumns));

            $sql = "INSERT INTO ".$this->getTableName()." VALUES (".$values.")";

            Application::$db->execute($sql);
        }

        public function update($columnValue, $values) {
            $columnValue = $this->transformParam($columnValue);
            foreach($values as $key => $value) {
                $values[$key] = $this->transformParam($value);
            }

            $setValues = "";
            foreach($values as $key => $value) {
                $setValues .= $setValues." ".$key."=".$value;
            } 

            $sql = "UPDATE ".$this->getTableName()." SET".$setValues." WHERE ".$this->setBaseColumn()."=".$columnValue;

            Application::$db->execute($sql);
        }

        public function delete($columnValue) {
            $columnValue = $this->transformParam($columnValue);

            $sql = "DELETE FROM ".$this->getTableName()." WHERE ".$this->setBaseColumn()."=".$columnValue;

            Application::$db->execute($sql);
        }

           

    }



?>