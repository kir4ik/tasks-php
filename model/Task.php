<?php

namespace model;

class Task extends Model
{
    const ID            = 'id';
    const CONTENT       = 'content';
    const USER_NAME     = 'user_name';
    const USER_EMAIL    = 'user_email';
    const STATUS        = 'status';
    const DATE_CREATED  = 'date_created';
    const DATE_UPDATED  = 'date_updated';

    function __construct()
    {
        parent::__construct();

        $this->table = 'tasks';
    }

    public function sort()
    {

    }

    public function getBatch(int $pos, int $limit, String $sortField = self::ID, String $sortMethod = self::SORT_DESC)
    {
        $sortMethod = $sortMethod === self::SORT_ASC ? self::SORT_ASC : self::SORT_DESC;

        $sql = sprintf('SELECT * FROM %s ORDER BY %s %s LIMIT %s, %s', $this->table, $sortField, $sortMethod, $pos, $limit);

        $st = $this->db->prepare($sql);
        
        return $st->execute() ? $st->fetchAll(\PDO::FETCH_ASSOC) : false;
    }

    public function getCount()
    {
        $sql = sprintf('SELECT COUNT(*) FROM %s', $this->table);

        $st = $this->db->prepare($sql);
        
        return $st->execute() ? $st->fetch(\PDO::FETCH_NUM)[0] : false;
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

    public function changeStatus($id, $newStatus)
    {
        $status = self::STATUS .'=:'. self::STATUS;

        $sql = sprintf('UPDATE %s SET %s WHERE id=:id', $this->table, $status);
        $st = $this->db->prepare($sql);

        $params[self::STATUS] = $newStatus;        
        $params[':id'] = $id;        

        return $st->execute($params);
    }
}