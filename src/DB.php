<?php

namespace SimplePdoWrapper;

use \PDO;
use \PDOStatement;

class DB
{
    private static $pdo;
    private static $current_conn;
    private static $config;

    public static function setConfig(string $config_src): void
    {
        self::$config = include($config_src);
    }

    public static function connection(string $connection_key = 'default'): PDO
    {
        self::$current_conn = $connection_key;
        $current_config = ($connection_key == 'default') ? self::$config[self::$config[$connection_key]]
            : self::$config[$connection_key];

        if (empty(self::$pdo[self::$current_conn])) {
            self::$pdo[self::$current_conn] = new PDO($current_config['dsn'], $current_config['username'],
                $current_config['password'], $current_config['options']);
        }

        return self::getPdo();
    }

    public static function getPdo(): PDO
    {
        return self::$pdo[self::$current_conn];
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::getPdo(), $method], $args);
    }

    public static function request(string $sql, array $params): PDOStatement
    {
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    private function __construct(){}

    private function __clone(){}

    private function __wakeup(){}
}