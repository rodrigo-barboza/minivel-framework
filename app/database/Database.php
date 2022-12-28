<?php

class Database {
    private $pdo;

    private function __construct()
    {
        $core = Core::getInstance();
        $db = $core->getConfig('database');

        try {
        
            $this->pdo = new PDO(
                "{$db['driver']}:host={$db['host']};dbname={$db['database']}",
                $db['username'],
                $db['password']
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Database();
        }

        return $instance;
    }

    public function query($sql)
    {
        return $this->pdo->query($sql);
    }
    
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    public function execute($array)
    {
        return $this->pdo->execute($array);
    }
    
    public function exec($sql)
    {
        return $this->pdo->exec($sql);
    }
}