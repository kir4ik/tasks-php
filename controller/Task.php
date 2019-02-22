<?php

namespace controller;

use model\Task as mTask;

class Task extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new mTask();
    }

    public function actionList()
    {
        $this->content = $this->build('task/list', [
            'tasks' => $this->model->getList()
        ]);
    }

    public function actionCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name   = $_POST['name'] ?? '';
            $email  = $_POST['email'] ?? '';
            $text   = $_POST['text'] ?? '';

            $name = trim(htmlspecialchars($name));
            $email = trim(htmlspecialchars($email));
            $text = trim(htmlspecialchars($text));

            $data = [
                $this->model::USER_NAME => $name,
                $this->model::USER_EMAIL => $email,
                $this->model::CONTENT => $text
            ];

            $this->model->insert($data);
        }

        $this->content = $this->build('task/create');
    }
}