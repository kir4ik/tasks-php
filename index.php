<?php

require_once 'functions.php';

install();

echo "Hello Word";

$controller = new controller\Task();
$controller->actionList();
// $controller->actionCreate();
$controller->render();