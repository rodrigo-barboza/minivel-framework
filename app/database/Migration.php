<?php

require "./support/DatabaseConstants.php";

class Migration {
    private $TYPES = [
        'int',
        'varchar',
        'char',
        'text',
        'timestamp'
    ];

    private $pdo;

    public function __construct()
    {
        require "config.php";

        $db = $config['database'];

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

    public function create(string $table_name, array $rules)
    {
        $formatted_rules = $this->createRules($rules);
        $query = "CREATE TABLE $table_name ($formatted_rules) CHARSET=utf8;";

        if (!$this->tableExists($table_name)) {
            $this->pdo->exec($query);
            echo "tabela $table_name criada na base de dados com sucesso.";
        } else {
            echo "Tabela já existente no banco. ";
        }
    }

    private function tableExists(string $table_name): bool
    {
        $sql = $this->pdo->query('show tables');

        $tables = $sql->fetchAll();
        
        foreach($tables as $table) {
            $value = array_values($table);
            
            if (in_array($table_name, $value)) {
                return true;
            }
        }
        
        return false;
    }

    private function createRules(array $rules)
    {
        $line = '';
        $pk = '';

        foreach($rules as $key => $props) {
            if ($this->typeIsValid($props)) {
                $line .= "$key ";
                $line .= $props['type'];
                $line .= " ".$this->nullable($props);
                $line .= " ".$this->timestamp($props);
                $line .= " ".$this->autoIncrement($props);
                $line .= ", ";

                if ($pk === '') {
                    $pk = $this->primaryKey($key, $props);
                }
            }
        }

        return $line.$pk;
    }

    private function typeIsValid(array $item): bool
    {
        $slice_point = strpos($item['type'], '(');
        $type = $slice_point ? substr($item['type'], 0, $slice_point) : $item['type'];

        return in_array('type', array_keys($item)) && in_array($type, $this->TYPES);
    }

    private function primaryKey(string $key, array $item)
    {
        if (in_array('primary_key', array_keys($item)) && $item['primary_key']) {
            return DatabaseConstants::PRIMARY_KEY."($key)";
        }

        return '';
    }

    private function nullable(array $item): string
    {
        if (in_array('nullable', array_keys($item)) && $item['nullable']) {
            return DatabaseConstants::NULLABLE;
        }

        return DatabaseConstants::NOT_NULL;
    }

    private function autoIncrement(array $item): string
    {
        if (in_array('auto_increment', array_keys($item)) && $item['auto_increment']) {
            return DatabaseConstants::AUTO_INCREMENT;
        }

        return '';
    }

    private function timestamp(array $item): string
    {
        $timestamp = '';

        if (in_array('timestamp', array_keys($item)) && $item['timestamp']) {
            $timestamp = " DEFAULT ".DatabaseConstants::CURRENT_TIMESTAMP."()";
        }

        return $timestamp;
    }

}