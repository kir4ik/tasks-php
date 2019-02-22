<?php

namespace model;

class Task extends Model
{
    const ID = 'id';
    const CONTENT = 'content';
    const USER_NAME = 'user_name';
    const USER_EMAIL = 'user_email';
    const DATE_CREATED = 'date_created';
    const DATE_UPDATED = 'date_updated';

    function __construct()
    {
        parent::__construct();

        $this->table = 'tasks';
    }

    public function getList()
    {
        $sql = sprintf('SELECT * FROM %s', $this->table);

        $st = $this->db->prepare($sql);
        
        return $st->execute() ? $st->fetchAll(\PDO::FETCH_ASSOC) : false;
    }

    public function insert(Array $data)
    {
        $cols = array_keys($data);
        $maskVals = array_map(function ($el) {
            return ":$el";
        }, $cols);

        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, implode(',', $cols), implode(',', $maskVals));

        $st = $this->db->prepare($sql);

        $params = [];
        foreach ($data as $mask => $val) {
            $params[":$mask"] = $val;
        }
        
        return $st->execute($params) ? $this->db->lastInsertId() : false;
    }
}