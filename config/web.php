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
                [ 'pattern' => '/', 'method' => 'GET', 'route' => 'site/index', 'defaults' => ['code' => 'home']],
                [ 'pattern' => '/login', 'method' => 'POST', 'route' => 'login/login', 'defaults' => ['code' => 'login']],
                [ 'pattern' => '/register', 'method' => 'POST', 'route' => 'login/register', 'defaults' => ['code' => 'register']],
            ],
        ]
    ]
];