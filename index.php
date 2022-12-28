<?php
session_start();

require "config.php";

spl_autoload_register(function($class) {
    if (file_exists("app/$class/$class.php")) {
        require "app/$class/$class.php";
    }
});

Core::getInstance()->run($config);
