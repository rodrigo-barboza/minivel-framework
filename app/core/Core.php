<?php 

class Core {
    private $config;
    private $db;

    private function __construct(){}

    // singleton
    public static function getInstance()
    {
        static $instance = null;

        if ($instance == null) {
            $instance = new Core();
        }

        return $instance;
    }

    public function run($config)
    {
        $this->config = $config;
        $this->db = $this->loadModule('database');
        $this->loadModule('router')->load()->match();
    }

    public function getConfig($name)
    {
        return $this->config[$name];
    }

    public function getConnection()
    {
        return $this->db;
    }

    // função responsável por carregar os módulos
    public function loadModule(string $module_name)
    {
        try {
            $module_name = ucfirst(strtolower($module_name));
            $module = $module_name::getInstance();
        } catch (Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
        
        return $module;
    }
}
