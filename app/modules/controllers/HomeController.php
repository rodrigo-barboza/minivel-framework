<?php

class HomeController {

    public function __construct()
    {

    }

    public function index($data)
    {
        echo "opaaan meu lindo, recebi via get esse cabinha: ". $data['id'];
    }
}