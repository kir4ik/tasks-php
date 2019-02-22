<?php

namespace controller;

abstract class controller
{
    protected $title;
    protected $content;

    public function __construct()
    {
        $this->title = 'Tasks';
        $this->content = '';
    }

    public function render()
    {
        echo $this->build('index', [
            'title' => $this->title,
            'content' => $this->content,
        ]);
    }

    public function build(String $view, Array $params = [])
    {
        ob_start();

        extract($params);
        include_once 'view/' . $view . '.html.php';

        return ob_get_clean();
    }
}