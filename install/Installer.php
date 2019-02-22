<?php

namespace install;

use core\DBConnect;

class Installer
{
    public static function run()
    {
        $isSuccess = false;

        $tables = include 'tables.php';
        $isSuccess = self::createTable('tasks', $tables['tasks']);

        return $isSuccess;
    }

    private static function createTable(String $table, Array $fields)
    {
        $isSuccess = false;

        $params = [];
        foreach ($fields as $key => $val) {
            $params[] = "$key $val";
        }
        $params = implode(',', $params);

        $sql = sprintf('CREATE TABLE IF NOT EXISTS `%s`(%s) ENGINE = InnoDB', $table, $params);

        try {
            $pdo = DBConnect::getConnect();
            $statement = $pdo->prepare($sql);
            $isSuccess = $statement->execute();
            
        } catch (\Exception $e){
            custom_print($e->getMessage());
            $isSuccess = false;
        }

        return $isSuccess;
    }
}