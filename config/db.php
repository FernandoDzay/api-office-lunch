<?php

    $env = "prod";

    if($env === "prod") {
        $db = [
            'dbname' => 'sql5438232',
            'host' => 'sql5.freesqldatabase.com',
            'user' => 'sql5438232',
            'password' => 'fC1wzMbDbC',
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