<?php

require "app/core/Model.php";

class User extends Model {
    protected $fields = [
        'id',
        'name',
        'email',
        'password',
    ];

    public function __construct()
    {
        parent::__construct('users', $this->fields);
    }
}