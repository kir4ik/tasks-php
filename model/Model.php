<?php

namespace model;

use core\DBConnect;

abstract class Model
{
    const SORT_DESC = 'desc';
    const SORT_ASC  = 'asc';

    public function __construct()
    {
        $this->db = DBConnect::getConnect();
    }
}