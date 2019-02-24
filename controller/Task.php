<?php

namespace controller;

use model\Task as mTask;

class Task extends Controller
{
    const RECORD_LIMIT = 3;
    const PAGE_DEFAULT = 1;

    const NAME_SORT_FIELD   = 'field';
    const NAME_SORT_METHOD  = 'sort';

    const PAGE  = 'page';

    function __construct()
    {
        parent::__construct();
        $this->model = new mTask();
    }

    // list all tasks
    public function actionList()
    {
        $this->navs[self::NAV_NAME_LIST][self::NAV_IS_ACTIVE] = true;

        $pageN = $this->getPageN();
        // define sort [who => default value]
        $resSpotSort = $this->spotSort([
            self::NAME_SORT_FIELD   => $this->model::USER_NAME,
            self::NAME_SORT_METHOD  => $this->model::SORT_DESC
        ]);
        // define limit
        $pos = ($pageN * self::RECORD_LIMIT) - self::RECORD_LIMIT;
        $tasks = $this->model->getBatch($pos, self::RECORD_LIMIT, $resSpotSort[self::NAME_SORT_FIELD], $resSpotSort[self::NAME_SORT_METHOD]);
        // define count pages
        $countPages = (int) $this->model->getCount() / (int) self::RECORD_LIMIT;
        $countPages = (int) ceil((float) $countPages);
        // set logic status
        if (!empty($tasks)) foreach ($tasks as &$task) {
            $task['isCompleted'] = (int) $task[$this->model::STATUS] === 1;
        }
        // data for display in form
        $dataSort = $this->getDataSort([
            self::NAME_SORT_FIELD   => $resSpotSort[self::NAME_SORT_FIELD],
            self::NAME_SORT_METHOD  => $resSpotSort[self::NAME_SORT_METHOD]
        ]);

        $this->content = $this->build('task/list', [
            'dataSort' => $dataSort,
            'tasks' => $tasks,
            'countPages' => $countPages,
            'currentPageN' => $pageN
        ]);
    }

    // post handler for eddit task
    public function actionEdit()
    {
        $id = $_POST[$this->model::ID];
        $status = $_POST[$this->model::STATUS] ? 1 : 0;
        $text = $_POST[$this->model::CONTENT];

        $text = trim(htmlspecialchars($text));

        if (empty($text)) {
            // error
            die('Error field with deskription of task do not must empty!');
        }

        if (!is_numeric($id)) {
            // error
            die('Error ID incorrect '.$id);
        }

        $isSuccess = $this->model->updateById($id, [
            $this->model::STATUS => $status,
            $this->model::CONTENT => $text
        ]);

        if ($isSuccess) redirect('/');

        // error
        die('An error occurred while trying to update the data!');
    }

    // show form of create new task
    public function actionShowCreate()
    {
        $this->navs[self::NAV_NAME_CREATE][self::NAV_IS_ACTIVE] = true;

        $this->content = $this->build('task/create');
    }

    // post hendler for create new task
    public function actionCreate()
    {
        $this->navs[self::NAV_NAME_CREATE][self::NAV_IS_ACTIVE] = true;

        $name   = getVal($_POST[$this->model::USER_NAME]); // get val if exists else ''
        $email  = getVal($_POST[$this->model::USER_EMAIL]); // get val if exists else ''
        $text   = getVal($_POST[$this->model::CONTENT]); // get val if exists else ''

        $name   = trim(htmlspecialchars($name));
        $email  = trim(htmlspecialchars($email));
        $text   = trim(htmlspecialchars($text));

        $data = [
            $this->model::USER_NAME     => $name,
            $this->model::USER_EMAIL    => $email,
            $this->model::CONTENT       => $text
        ];

        $isValid = true;
        foreach ($data as $val) {
            if (empty($val)) $isValid = false;
        }

        if ($isValid && $this->model->insert($data)) {
            $_POST = [];
        }

        $this->content = $this->build('task/create', [
            'isValid' => $isValid
        ]);
    }

    // show form sign in
    public function actionShowLogin()
    {
        $this->profile[self::PROFILE_IS_ACTIVE] = true;

        if (self::isAdmin()) redirect('/');

        $this->content = $this->build('profile/login');
    }

    // try done login
    public function actionLogin()
    {
        $this->profile[self::PROFILE_IS_ACTIVE] = true;

        if (self::isAdmin()) redirect('/');
        
        if ($_POST['login'] === 'admin' && $_POST['pass'] === '123') {
            $this->rememberAdmin();
            $this->profile[self::PROFILE_IS_AUTH] = true;
            redirect('/');
        }

        $this->content = $this->build('profile/login', ['isSuccess' => false]);
    }

    // logout
    public function actionLogout()
    {
        if (self::isAdmin()) {
            $this->forgetAdmin();
            redirect('/');
        }

        die('unchought error');
    }

    private function getDataSort(Array $lastActiveData)
    {
        $dataSort = [
            self::NAME_SORT_FIELD => [
                $this->model::USER_NAME => ['label' => 'name', 'isActive' => true ],
                $this->model::USER_EMAIL => ['label' => 'email'],
                $this->model::STATUS => ['label' => 'status']
            ],
            self::NAME_SORT_METHOD  => [
                $this->model::SORT_DESC => [ 'label' => 'descending', 'isActive' => true ],
                $this->model::SORT_ASC  => [ 'label' => 'ascending' ]
            ]
        ];

        foreach ($lastActiveData as $nameSort => $key) {
            if ( array_key_exists($key, $dataSort[$nameSort]) ) {
                if ($dataSort[$nameSort][$key]['isActive']) continue;

                foreach ($dataSort[$nameSort] as &$val) unset($val['isActive']);

                $dataSort[$nameSort][$key]['isActive'] = true;
            }
        }

        return $dataSort;
    }

    private function spotSort(Array $data)
    {
        $res = [];
        foreach ($data as $nameSort => $defaultVal) {
            if (empty($_GET[$nameSort])) {
                if (empty($_COOKIE[$nameSort])) {
                    $res[$nameSort] = $defaultVal;
                } else {
                    $res[$nameSort] = $_COOKIE[$nameSort];
                }
            } else {
                $res[$nameSort] = $_GET[$nameSort];
            }
            setcookie($nameSort, $res[$nameSort], time() + 3600*24, '/'); // update coockie
        }

        return $res;
    }

    private function getPageN()
    {
        if (empty($_GET[self::PAGE])) {
            if (empty($_COOKIE[self::PAGE])) {
                $pageN = self::PAGE_DEFAULT;
            } else {
                $pageN = $_COOKIE[self::PAGE];
            }
        } else {
            $pageN = (int)$_GET[self::PAGE];
        }
        $pageN = $pageN < 1 ? self::PAGE_DEFAULT : $pageN;

        setcookie(self::PAGE, $pageN, time() + 3600*24, '/'); // update coockie

        return (int)$pageN;
    }
}