<?php

class Controller {
    private $view;
    private $core;
    private $db;

    private function __construct(){}

    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Controller();
        }

        return $instance;
    }

    public function loadController(string $controller_name)
    {
        if (file_exists("app/modules/$controller_name.php")) {
            require "app/modules/$controller_name.php";
        }

        $class_name = explode('/', $controller_name);
        $class_name = $class_name[array_key_last($class_name)];

        return new $class_name();
    }
}