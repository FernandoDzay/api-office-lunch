<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Content-type: application/json');

    require_once __DIR__."/../vendor/autoload.php";

    use App\core\Application;

    $application = new Application();
 
    $application->run();


?>