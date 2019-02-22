<?php

namespace model;

use core\DBConnect;

abstract class Model
{
    public function __construct()
    {
        $this->db = DBConnect::getConnect();
    }
}