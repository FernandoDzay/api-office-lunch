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

                // GET
                [ 'pattern' => '/', 'method' => 'GET', 'route' => 'site/index'],
                [ 'pattern' => '/get-foods', 'method' => 'GET', 'route' => 'site/getfoods'],
                [ 'pattern' => '/menu', 'method' => 'GET', 'route' => 'site/getmenu'],


                // POST
                [ 'pattern' => '/login', 'method' => 'POST', 'route' => 'login/login'],
                [ 'pattern' => '/register', 'method' => 'POST', 'route' => 'login/register'],
                [ 'pattern' => '/insert-food', 'method' => 'POST', 'route' => 'admin/insertfood'],
                [ 'pattern' => '/insert-food-of-the-day', 'method' => 'POST', 'route' => 'admin/inserttodaysfood'],
                [ 'pattern' => '/save-food', 'method' => 'POST', 'route' => 'admin/savefood'],


                // PUT
                [ 'pattern' => '/edit-food', 'method' => 'PUT', 'route' => 'admin/editfood'],
                [ 'pattern' => '/make-food-permanent', 'method' => 'PUT', 'route' => 'admin/makepermanent'],


                // DELETE
                [ 'pattern' => '/delete-food-from-menu', 'method' => 'DELETE', 'route' => 'admin/deletefoodfrommenu'],
                [ 'pattern' => '/delete-food', 'method' => 'DELETE', 'route' => 'admin/deletefood'],


            ],
        ]
    ]
];