<?php

namespace core;

class DBConnect
{
    private static $instance;
    private static $settings;
    
	public static function getConnect()
	{
		if (self::$instance === null) {
			self::$instance = self::getPDO();
		}
		return self::$instance;
    }
    
	private static function getPDO()
	{
        extract(self::getSettings(), EXTR_PREFIX_ALL, 'db');

        $dsn = sprintf('%s:host=%s;dbname=%s', $db_type, $db_host, $db_name);
        
		try {
			$db = new \PDO($dsn, $db_user, $db_pass);
			$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$db->exec('SET NAMES UTF8');
		} catch (\PDOException $e) {
			custom_print('Подключение не удалось: ' . $e->getMessage());
		}
		
		return $db;
    }
    
    private static function getSettings()
    {
        if (self::$settings === null) {
			self::$settings = include 'config/configDB.php';
        }

        return self::$settings;
    }
}