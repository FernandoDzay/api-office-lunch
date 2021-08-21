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
                [ 'pattern' => '/get-username', 'method' => 'GET', 'route' => 'site/getusername'],
                [ 'pattern' => '/orders/get-by-user', 'method' => 'GET', 'route' => 'orders/getbyuser'],
                [ 'pattern' => '/get-extras', 'method' => 'GET', 'route' => 'site/getextras'],
                [ 'pattern' => '/get-users', 'method' => 'GET', 'route' => 'site/getusers'],
                [ 'pattern' => '/get-groups', 'method' => 'GET', 'route' => 'groups/getgroups'],
                [ 'pattern' => '/user-has-group', 'method' => 'GET', 'route' => 'groups/userhasgroup'],
                [ 'pattern' => '/groups-data', 'method' => 'GET', 'route' => 'groups/groupsdata'],
                [ 'pattern' => '/get-week-orders-by-user', 'method' => 'GET', 'route' => 'orders/getweekordersbyuser'],
                [ 'pattern' => '/get-week-orders', 'method' => 'GET', 'route' => 'orders/getweekorders'],
                [ 'pattern' => '/get-orders-data', 'method' => 'GET', 'route' => 'orders/getordersdata'],
                [ 'pattern' => '/make-order', 'method' => 'GET', 'route' => 'orders/makeorder'],
                [ 'pattern' => '/get-notifications', 'method' => 'GET', 'route' => 'notifications/get'],
                [ 'pattern' => '/get-lunch-hour', 'method' => 'GET', 'route' => 'groups/getlunchhour'],


                // POST
                [ 'pattern' => '/login', 'method' => 'POST', 'route' => 'login/login'],
                [ 'pattern' => '/register', 'method' => 'POST', 'route' => 'login/register'],
                [ 'pattern' => '/token-login', 'method' => 'POST', 'route' => 'login/tokenlogin'],
                [ 'pattern' => '/insert-food', 'method' => 'POST', 'route' => 'admin/insertfood'],
                [ 'pattern' => '/insert-food-of-the-day', 'method' => 'POST', 'route' => 'admin/inserttodaysfood'],
                [ 'pattern' => '/save-food', 'method' => 'POST', 'route' => 'admin/savefood'],
                [ 'pattern' => '/insert-extra', 'method' => 'POST', 'route' => 'admin/insertextra'],
                [ 'pattern' => '/orders/add', 'method' => 'POST', 'route' => 'orders/add'],
                [ 'pattern' => '/set-user-group', 'method' => 'POST', 'route' => 'groups/setusergroup'],
                [ 'pattern' => '/send-notification', 'method' => 'POST', 'route' => 'notifications/send'],


                // PUT
                [ 'pattern' => '/edit-food', 'method' => 'PUT', 'route' => 'admin/editfood'],
                [ 'pattern' => '/make-food-permanent', 'method' => 'PUT', 'route' => 'admin/makepermanent'],
                [ 'pattern' => '/edit-extra', 'method' => 'PUT', 'route' => 'admin/editextra'],
                [ 'pattern' => '/update-user-group', 'method' => 'PUT', 'route' => 'groups/updateusergroup'],
                [ 'pattern' => '/activate-user-group', 'method' => 'PUT', 'route' => 'groups/activateuserstatus'],
                [ 'pattern' => '/desactivate-user-group', 'method' => 'PUT', 'route' => 'groups/desactivateuserstatus'],
                [ 'pattern' => '/update-notifications', 'method' => 'PUT', 'route' => 'notifications/update'],
                


                // DELETE
                [ 'pattern' => '/delete-food-from-menu', 'method' => 'DELETE', 'route' => 'admin/deletefoodfrommenu'],
                [ 'pattern' => '/delete-food', 'method' => 'DELETE', 'route' => 'admin/deletefood'],
                [ 'pattern' => '/delete-extra', 'method' => 'DELETE', 'route' => 'admin/deleteextra'],
                [ 'pattern' => '/orders/delete', 'method' => 'DELETE', 'route' => 'orders/delete'],
                [ 'pattern' => '/remove-user-group', 'method' => 'DELETE', 'route' => 'groups/removeusergroup'],




                // CRON
                [ 'pattern' => '/cron', 'method' => 'GET', 'route' => 'site/cron'],


            ],
        ]
    ]
];