<?php

    $env = "prod";

    if($env === "prod") {
        $db = [
            'dbname' => 'sql5439971',
            'host' => 'sql5.freesqldatabase.com',
            'user' => 'sql5439971',
            'password' => 'NKrZfNgAps',
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