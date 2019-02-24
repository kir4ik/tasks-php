<?php

function __autoload($className) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
}

function custom_dump($val) {
    echo '<hr><pre>';
    var_dump($val);
    echo '</pre><hr>';
}

function custom_print($val) {
    echo '<hr><pre>';
    print($val);
    echo '</pre><hr>';
}

function install() {
    if ( !($isInstall = install\Installer::run()) ) {
        custom_print("Во время утановки произошла ошибка!");
    }
}

function getVal($val, $default = '') {
    return $val ?: $default;
}

function getReplaced($val, $success, $faild = '') {
    if (empty($val)) return $faild;

    return $success;
}

function redirect(String $path) {
    header("Location: $path");
    exit();
}