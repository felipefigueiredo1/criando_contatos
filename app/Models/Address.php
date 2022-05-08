<?php

namespace App\Models;

use CoffeeCode\DataLayer\DataLayer;

class Address extends DataLayer
{
    public function __construct()
    {
        //Define o parametro primary pois o valor padrão não é id.
        parent::__construct("address", ["user_id"], "addr_id", false);
    }

    public function add(User $user, string $street, string $number): Address
    {
        $this->user_id = $user->id;
        $this->street = $street;
        $this->number = $number;

        return $this; 
    }
}