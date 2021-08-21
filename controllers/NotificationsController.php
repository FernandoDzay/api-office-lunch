<?php

namespace App\controllers;

use App\core\base\Controller;
use App\core\Application;
use App\models\Notification;

class NotificationsController extends Controller {

    public function actionSend() {

        $title = "";
        $description = "";
        $users = [];


        if( isset($_REQUEST['title']) && isset($_REQUEST['description']) ) {
            $title = $_REQUEST['title'];
            $description = $_REQUEST['description'];
        }
        else {
            die("No tenemos data suficiente para la inserción");
        }

        $notification = new Notification($title, $description);

        if( isset($_REQUEST['created_by']) ) $notification->created_by($_REQUEST['created_by']);
        if( isset($_REQUEST['type']) ) $notification->type($_REQUEST['type']);


        if( isset($_REQUEST['users']) ) {
            $users = json_decode($_REQUEST['users'], true);
            if(!is_array($users)) die("users debe de ser un arreglo");

            $notification->send($users);
        }
        else {
            $notification->sendAll();
        }

    }

    public function actionUpdate() {
        if( !isset($_REQUEST['ids']) ) die();

        $ids = json_decode($_REQUEST['ids'], true);


        Notification::markAsRead($ids);
    }

    public function actionGet() {
        if(!isset($_REQUEST['user_id'])) {
            die("Se necesita user_id");
        }

        $user_id = $_REQUEST['user_id'];

        $notifications = Notification::getNotifications($user_id);

        echo json_encode($notifications);
    }

}



?>