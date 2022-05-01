<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';


use app\core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');

$app->router->get('/kurse', 'kurse');

$app->router->post('kurse', '');

$app->run();
