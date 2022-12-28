<?php

$this->get('', function() {
    echo 'ola meu querido. ';
});

$this->get('home', function() {
    echo 'ola meu home. ';
});

$this->get('home/{id}', ['controllers/HomeController', 'index']);

$this->get('about', ['controllers/AboutController', 'page']);

$this->loadRouteFile('dashboard');
