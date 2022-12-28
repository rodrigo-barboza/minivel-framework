<?php

require "app/modules/models/User.php";

class AboutController {
    public function page($data)
    {
        $user = new User();
        // encontre o registro de id = 1, mas pegue apenas os campos de nome e email
        $result = $user->findById(1, ['name', 'email']);

        // encontre o registro de id = 1, pegue apenas nome e email, com nome = rodrigo teste e email = rodrigo@teste.com
        $result = $user->findWhere(['name', 'email', 'password'], ['name' => 'rodrigo teste', 'email' => 'rodrigo@teste.com']);

        // insere e verifica se o campo é válido na tabela (se for insere)
        $user->insert(['name' => 'rodrigo b2', 'email' => 'rodrigob222@yashoo.com']);

        $this->view->render('about', $result);
    }
}
