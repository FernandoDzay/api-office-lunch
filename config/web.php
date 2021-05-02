<?php

require "db.php";

$config = [
    'layout' => 'main',
    'db' => $db,
    'backendApi' => true,
    'components' => [
        'functions' => [
            'GlobalFunctions' => [ 'class' => 'App\GlobalFunctions\GlobalFunctions'],
            'DataBaseFunctions' => [ 'class' => 'App\GlobalFunctions\DataBaseFunctions'],
        ],
        'urlManager' => [
            'rules' => [
                [ 'pattern' => '/', 'method' => 'DELETE', 'route' => 'site/index', 'defaults' => ['code' => 'login']],
                [ 'pattern' => '/login', 'method' => 'GET', 'route' => 'login/login', 'defaults' => ['code' => 'login']],
            ],
        ]
    ]
];