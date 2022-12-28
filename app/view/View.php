<?php 

class View {
    private $core;
    private $get;
    private $post;

    private function __construct(){}

    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new View();
        }

        return $instance;
    }

    public function render(string $view_name, array $data)
    {
        if (file_exists("views/$view_name.php")) {
            require "views/$view_name.php";
        }
    }
}