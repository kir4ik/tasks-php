<?php

namespace core;

interface iRouter
{
    public function route(String $request);
    public function get(String $action);
    public function post(String $action);
    public function all(String $action);
    public function run();
}