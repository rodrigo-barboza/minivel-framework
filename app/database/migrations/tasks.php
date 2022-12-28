<?php

require "./app/database/Migration.php";

class Tasks {
    public function __construct()
    {
        $this->migrate();
    }

    public function migrate()
    {
        (new Migration())->create('tasks', [
            'id' => [
                'type' => 'int',
                'primary_key' => true,
                'auto_increment' => true,
            ],
            'task_name' => [
                'type' => 'varchar(50)',
                'nullable' => false,
            ],
            'created_at' => [
                'type' => 'timestamp',
                'timestamp' => true,
            ]
        ]);
    }
}

new Tasks();
