<?php

session_start();

require_once 'functions.php';

use core\Router;

install();

$router = new Router();

/**
 * home - list tasks
 */
$router->route('/')->all('task.list');
/**
 * create new task
 */
$router->route('/create')
    ->get('task.showCreate')
    ->post('task.create');
/**
 * handler for edit of task
 */
$router->route('/task/edit')->post('task.edit');
/**
 * login
 */
$router->route('/sign-in')
    ->get('task.showLogin')
    ->post('task.login');
/**
 * logout
 */
$router->route('/logout')
    ->get('task.logout');
/**
 * begin handler rouetes
 */
$router->run();