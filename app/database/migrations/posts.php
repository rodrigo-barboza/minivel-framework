<?php

require "./app/database/Migration.php";

class Posts {
    public function __construct()
    {
        $this->migrate();
    }

    public function migrate()
    {
        (new Migration())->create('posts', [
            'id' => [
                'type' => 'int',
                'primary_key' => true,
                'auto_increment' => true,
            ],
            'name' => [
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

new Posts();
