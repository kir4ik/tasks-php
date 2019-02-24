<?php

namespace controller;

abstract class controller
{
    const NAV_LINK          = 'link';
    const NAV_IS_ACTIVE     = 'isActive';
    
    const NAV_NAME_LIST     = 'List';
    const NAV_NAME_CREATE   = 'Create';

    const PROFILE_IS_ACTIVE = 'isActive';
    const PROFILE_IS_AUTH   = 'isAuth';

    const IS_ADMIN          = 'isAdmin';

    protected $title;
    protected $content;
    protected $navs;
    protected $profile;

    public function __construct()
    {
        $this->title = 'Tasks';
        $this->content = '';
        $this->navs = [
            self::NAV_NAME_LIST => [
                self::NAV_LINK         => '/',
                self::NAV_IS_ACTIVE    => false
            ],
            self::NAV_NAME_CREATE => [
                self::NAV_LINK         => '/create',
                self::NAV_IS_ACTIVE    => false
            ]
        ];
        $this->profile = [
            self::PROFILE_IS_ACTIVE => false,
            self::PROFILE_IS_AUTH   => self::isAdmin()
        ];
    }

    public function render()
    {
        echo $this->build('index', [
            'title'     => $this->title,
            'navs'      => $this->navs,
            'profile'   => $this->profile,
            'content'   => $this->content
        ]);
    }

    public function build(String $view, Array $params = [])
    {
        ob_start();

        extract($params);
        include_once 'view/' . $view . '.html.php';

        return ob_get_clean();
    }

    public function rememberAdmin()
    {
        $_SESSION[self::IS_ADMIN] = true;
    }

    public function forgetAdmin()
    {
        if (isset($_SESSION[self::IS_ADMIN])) {
            unset($_SESSION[self::IS_ADMIN]);
        }
    }

    public static function isAdmin()
    {
        return $_SESSION[self::IS_ADMIN] === true;
    }
}