<?php

class Model {
    private $table;
    private $fields;
    private $core;
    private $db;

    public function __construct(string $table, $fields)
    {
        $this->table = $table;
        $this->fields = $fields;
        $this->db = Database::getInstance();
    }

    public function findById($id, ?array $fields=[]): array
    {
        $query = $this->getQueryWithFields($fields, true);

        $sql = $this->db->prepare($query);
        $sql->bindValue(':id', $id);
        $sql->execute();

        return $sql->fetchAll();
    }

    private function getQueryWithFields(array $fields, ?bool $with_id=false): string
    {
        if (count($fields)) {
            $only_fields = implode(',', $fields);

            return "select $only_fields from $this->table";
        } 

        return "select * from $this->table ${$with_id ? 'where id=:id' : ''}";
    }

    public function findWhere(?array $fields=[], ?array $conditions=[]): array
    {
        $query = $this->getQueryWithFields($fields);
        $query = $this->getQueryWithConditions($query, $conditions);

        $sql = $this->db->query($query);

        return $sql->fetchAll();
    }

    public function getQueryWithConditions(string $query, array $conditions): string
    {
        $condition_str = '';
        $condition_len = count($conditions);

        if ($condition_len) {
            foreach($conditions as $field => $value) {
                $condition_str .= "$field='$value'";
                $condition_len--;

                if ($condition_len) {
                    $condition_str .= ' and ';
                }
            }
        }

        return "$query where $condition_str";
    }

    private function getInsertQuery(array $payload): array
    {
        $keys = implode(',', array_keys($payload));
        $values = implode(',', array_values($payload));
        
        $bind_values = str_repeat('?,', count($payload));
        $bind_values = explode(',', $bind_values);
        array_pop($bind_values);
        $bind_values = implode(',', $bind_values);
        
        $query = "insert into $this->table ($keys) values ($bind_values)";

        return [
            explode(',', $values),
            $query
        ];
    }

    public function insert(array $payload)
    {
        try {
            $this->payloadIsFillable($payload);

            list($values, $query) = $this->getInsertQuery($payload);
            $sql = $this->db->prepare($query);

            return $sql->execute($values);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }

    public function payloadIsFillable(array $payload): bool
    {
        foreach($payload as $key => $value) {
            if (!in_array($key, $this->fields)) {
                throw new Exception("O campo: '$key' é inválido.");
            }
        }

        return true;
    }
}