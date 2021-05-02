<?php

    namespace App\core\http;

    class REST {

        private $handle;

        public function __construct() {
            $this->handle = curl_init();

            // Will return the response, if false it prints the response
            curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);

            // set content type
            //curl_setopt($this->handle, CURLOPT_HTTPHEADER, ['content-type: application/json']);
        }


        public function get($url, $params = []) {

            if(!empty($params)) {
                $url .= "?".http_build_query($params);
            }

            // Set the url
            curl_setopt($this->handle, CURLOPT_URL, $url);

            // set get method
            curl_setopt($this->handle, CURLOPT_HTTPGET, true);

            // Execute the session and store the contents in $result
            $result = curl_exec($this->handle);

            // Closing the session
            curl_close($this->handle);

            return $result;
        }

        public function post($url, $params = []) {
            
            curl_setopt($this->handle, CURLOPT_URL, $url);

            curl_setopt($this->handle, CURLOPT_POST, true);

            curl_setopt($this->handle, CURLOPT_POSTFIELDS, $params);

            $result = curl_exec($this->handle);

            curl_close($this->handle);

            return $result;
        }

        public function put($url, $params = []) {

            if(!empty($params)) {
                $url .= "?".http_build_query($params);
            }


            curl_setopt($this->handle, CURLOPT_URL, $url);

            curl_setopt($this->handle, CURLOPT_PUT, true);

            $result = curl_exec($this->handle);

            curl_close($this->handle);

            return $result;

        }

        public function delete($url, $params = []) {

            if(!empty($params)) {
                $url .= "?".http_build_query($params);
            }

            curl_setopt($this->handle, CURLOPT_URL, $url);

            curl_setopt($this->handle, CURLOPT_CUSTOMREQUEST, "DELETE");

            $result = curl_exec($this->handle);

            curl_close($this->handle);

            return $result;
        }


    }






?>