<?php

require_once 'functions.php';

use core\Router;

install();

$router = new Router();

$router->route('/')->all('task.list');

$router->route('/create')
    ->get('task.showCreate')
    ->post('task.create');

// $router->route('/sign-in')
//     ->get('task.showLogin')
//     ->post('task.login');

$router->run();