<?php

    $env = "prod";

    if($env === "prod") {
        $db = [
            'dbname' => 'api-office-lunch',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
        ];
    }
    else {
        $db = [
            'dbname' => 'api-office-lunch',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
        ];
    }



?>