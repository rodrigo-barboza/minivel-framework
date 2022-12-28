<?php 
require "app/core/Controller.php";

class Router {
    private $core;
    private $get;
    private $post;
    private $view;

    private function __construct(){}

    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new Router();
        }

        return $instance;
    }

    public function load()
    {
        $this->core = Core::getInstance();
        $this->controller = Controller::getInstance();
        $this->view = $this->core->loadModule('view');
        $this->loadRouteFile('web');

        return $this;
    }

    public function loadRouteFile(string $file)
    {
        if (file_exists('routes/' . $file . '.php')) {
            require 'routes/' . $file . '.php';
        }
    }

    public function match()
    {
        $url = ((isset($_GET['url'])) ? $_GET['url'] : '');

        switch ($_SERVER{'REQUEST_METHOD'}) {
            case 'GET': 
            default:
                $method = $this->get;
                break;
            case 'POST':
                $method = $this->post;
                break;
        }

        foreach ($method as $pattern => $param) {
            $pattern_regex = preg_replace('(\{[a-z0-9]{0,}\})', '([a-z0-9]{0,})', $pattern);
            $dynamic_url_regex = '#^('. $pattern_regex .')*$#i';

            if (preg_match($dynamic_url_regex, $url, $matches)) {
                array_shift($matches);
                array_shift($matches);

                $args = [];

                if (preg_match_all('(\{[a-z0-9]{0,}\})', $pattern, $matches_all)) {
                    $args = preg_replace('(\{|\})', '', $matches_all[0]);
                }
                
                $arg = [];
                
                foreach($matches as $key => $match) {
                    $arg[$args[$key]] = $match;
                }

                if (gettype($param) == 'array') {
                    list($controller_name, $controller_action) = $param;

                    $current_controller = $this->controller->loadController($controller_name);
                    $current_controller->view = $this->view;
                    $current_controller->core = $this->core;
                    $current_controller->db = $this->core->getConnection();

                    $current_controller->$controller_action($arg);

                    break;
                }

                $param($arg);

                break;
            }
        }
    }
    
    public function get($pattern, $params)
    {
        $this->get[$pattern] = $params;
    }
    
    public function post($pattern, $function)
    {
        $this->post[$pattern] = $function;
    }
}
