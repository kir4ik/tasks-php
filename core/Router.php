<?php

namespace core;

class Router implements iRouter
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_ALL = 'ALL';
    const DEFAULT_ROUTE = '/';

    protected $request;
    protected $collection;
    protected $lastRoute;

    function __construct() {
        $this->colletion = [];
        $this->request = $this->getRequest();
        $this->lastRoute = self::DEFAULT_ROUTE;
    }

    public function route(String $request)
    {
        if (empty($request)) {
            throw new \Exception("request in not empty --- $request");
        }

        $this->lastRoute = $request;

        return $this;
    }

    public function get(String $action)
    {
        $this->colletion[$this->lastRoute][self::METHOD_GET] = $this->getDoer($action);

        return $this;
    }

    public function post(String $action)
    {
        $this->colletion[$this->lastRoute][self::METHOD_POST] = $this->getDoer($action);

        return $this;
    }

    public function all(String $action)
    {
        $this->colletion[$this->lastRoute][self::METHOD_ALL] = $this->getDoer($action);

        return $this;
    }

    public function run()
    {
        if ($this->isExistsRoute($this->request)) {
            $route = $this->colletion[$this->request];

            $doer = $route[self::METHOD_ALL] ?: $route[$this->getMethod()];
            
            $controller = new $doer['controller']();
            $action = $doer['action'];

            $params = []; // it must will fix

            call_user_func_array(array($controller, $action), $params);

            $controller->render();
        }
        else {
            die("404 Not Found");
        }
    }

    protected function isExistsRoute($request)
    {
        return isset($this->colletion[$request]);
    }

    protected function isMatchMethod($request)
    {
        return isset($this->colletion[$request]);
    }

    protected function getMethod()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case self::METHOD_POST:
                return self::METHOD_POST;

            default:
                return self::METHOD_GET;
        }
    }

    protected function getRequest()
    {
        $uri = rtrim($_SERVER['REQUEST_URI'], '/');
        $uri = array_filter(explode('/', $uri));
        $uri = '/'. implode('/', $uri);

        $pos = strpos($uri, '?');
        if ( $pos === false ) {
            $this->request = $uri;
        }
        elseif ($pos > 0) {
            $this->request = substr($uri, 0, $pos);
        }
        else {
            $this->request = '';
        }

        return $this->request ?: self::DEFAULT_ROUTE;
    }

    protected function getDoer(String $str)
    {
        if ( count($parts = explode('.', $str)) !== 2 ) {
            throw new \Exception("action incorect --- $str");
        }

        return [
            'controller' => sprintf('controller\%s', ucfirst($parts[0])),
            'action' => sprintf('action%s', ucfirst($parts[1])),
        ];
    }
}