<?php

namespace App\Models;

/**
 * Nesse CRUD estarei fazendo uso da lib DataLayer para abstrção de banco de dados, com PDO.
 */
use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer
{
    public function __construct()
    {
        //Chamando método construct da classe pai e definindo os parametros
        parent::__construct("users", ["nome", "sobrenome"]);
    }
}